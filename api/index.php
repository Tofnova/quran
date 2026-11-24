<?php
/*
  api.php
  ───────────────────────────────────────────────
  api.php                → random ১টা আয়াত (reload দিলেই বদলায়)
  api.php?id=100         → ১০০ নম্বর আয়াত
  api.php?ayat=5         → প্রথম ৫টা আয়াত (page 1)
  api.php?ayat=5&p=2     → পরের ৫টা আয়াত (৬–১০)
  api.php?f=120&t=200    → ১২০ থেকে ২০০ পর্যন্ত সব (দুটোই সহ)
  (api.json দিয়েও চলবে, .htaccess থাকলে)

  অগ্রাধিকার: f/t  >  ayat/p  >  id  >  random
*/

header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, OPTIONS');
header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
header('Pragma: no-cache');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') { http_response_code(204); exit; }

const MAX_PER_PAGE = 500;   // ?ayat= এর সর্বোচ্চ সংখ্যা

function out($data, $code = 200) {
    http_response_code($code);
    echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
    exit;
}

function int_param($key) {
    if (!isset($_GET[$key]) || $_GET[$key] === '') return null;
    $v = filter_var($_GET[$key], FILTER_VALIDATE_INT);
    return $v === false ? false : $v;
}

function clean($row) {
    $row['ayat_Arbinc'] = ltrim($row['ayat_Arbinc'], "\xEF\xBB\xBF"); // BOM মুছে ফেলা
    return $row;
}

/* ── ডেটা লোড ── */
$file = __DIR__ . '/../quran.json';
if (!is_file($file)) out(['error' => 'quran.json পাওয়া যায়নি'], 500);
$all = json_decode(file_get_contents($file), true);
if (!is_array($all) || !$all) out(['error' => 'quran.json পড়া যায়নি'], 500);
$all = array_values($all);
$total = count($all);

// id ক্রমানুসারে না থাকলে id ধরে সাজিয়ে নেওয়া
if ((int)$all[0]['id'] !== 1 || (int)$all[$total - 1]['id'] !== $total) {
    usort($all, fn($a, $b) => $a['id'] <=> $b['id']);
}

$f = int_param('f'); $t = int_param('t');
$n = int_param('ayat'); $p = int_param('p');
$id = int_param('id');

/* ── ১) f ও t : range ── */
if (isset($_GET['f']) || isset($_GET['t'])) {
    if ($f === false || $t === false) out(['error' => 'f ও t সংখ্যা হতে হবে'], 400);
    $f = $f ?? 1;
    $t = $t ?? $total;
    if ($f < 1 || $t > $total || $f > $t) {
        out(['error' => "f ও t অবশ্যই ১ থেকে $total এর মধ্যে হতে হবে এবং f <= t হতে হবে"], 400);
    }
    $data = array_map('clean', array_slice($all, $f - 1, $t - $f + 1));
    out(['from' => $f, 'to' => $t, 'count' => count($data), 'data' => $data]);
}

/* ── ২) ayat ও p : pagination ── */
if (isset($_GET['ayat']) || isset($_GET['p'])) {
    if ($n === false || $p === false) out(['error' => 'ayat ও p সংখ্যা হতে হবে'], 400);
    $n = $n ?? 10;
    $p = $p ?? 1;
    if ($n < 1 || $n > MAX_PER_PAGE) out(['error' => 'ayat ১ থেকে ' . MAX_PER_PAGE . ' এর মধ্যে হতে হবে'], 400);
    $pages = (int)ceil($total / $n);
    if ($p < 1 || $p > $pages) out(['error' => "p অবশ্যই ১ থেকে $pages এর মধ্যে হতে হবে"], 404);

    $data = array_map('clean', array_slice($all, ($p - 1) * $n, $n));
    out([
        'page'        => $p,
        'per_page'    => $n,
        'total_pages' => $pages,
        'total'       => $total,
        'count'       => count($data),
        'next_page'   => $p < $pages ? $p + 1 : null,
        'prev_page'   => $p > 1 ? $p - 1 : null,
        'data'        => $data,
    ]);
}

/* ── ৩) id : নির্দিষ্ট আয়াত ── */
if (isset($_GET['id'])) {
    if ($id === false || $id < 1 || $id > $total) {
        out(['error' => "id অবশ্যই ১ থেকে $total এর মধ্যে হতে হবে"], 404);
    }
    out(clean($all[$id - 1]));
}

/* ── ৪) কিছু না দিলে : random ── */
out(clean($all[random_int(0, $total - 1)]));
