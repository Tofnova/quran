<?php
/*
  api.php
  ───────────────────────────────────────────────
  /api                   → random ১টা আয়াত (reload দিলেই বদলায়)
  /api?id=100            → ১০০ নম্বর আয়াত (১–৬২৩৬)
  /api?sura=5            → ৫ নম্বর সূরার সব আয়াত
  /api?sura=5&ayat=10    → ৫ নম্বর সূরার ১০ নম্বর আয়াত
  /api?f=120&t=200       → id ১২০ থেকে ২০০ পর্যন্ত সব (দুটোই সহ)

  অগ্রাধিকার: f/t  >  sura(+ayat)  >  id  >  random

  প্রতিটা আয়াতের ফরম্যাট:
  { id, suara_no, sura, ayat_no, ayat_bangla, ayat_bangla_u, ayat_arbic }
*/

header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, OPTIONS');
header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
header('Pragma: no-cache');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') { http_response_code(204); exit; }

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
    foreach (['ayat_arbic', 'ayat_bangla', 'ayat_bangla_u'] as $k) {
        if (isset($row[$k])) $row[$k] = ltrim($row[$k], "\xEF\xBB\xBF"); // BOM মুছে ফেলা
    }
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

$f = int_param('f');       $t = int_param('t');
$sura = int_param('sura'); $ayat = int_param('ayat');
$id = int_param('id');

/* ── ১) f ও t : id range ── */
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

/* ── ২) sura ও ayat ── */
if (isset($_GET['sura']) || isset($_GET['ayat'])) {
    if (!isset($_GET['sura'])) out(['error' => 'ayat দিতে হলে sura নম্বরও দিতে হবে (যেমন ?sura=5&ayat=10)'], 400);
    if ($sura === false || $sura < 1 || $sura > 114) out(['error' => 'sura অবশ্যই ১ থেকে ১১৪ এর মধ্যে হতে হবে'], 404);
    if ($ayat === false) out(['error' => 'ayat সংখ্যা হতে হবে'], 400);

    $rows = array_values(array_filter($all, fn($r) => (int)$r['suara_no'] === $sura));
    $count = count($rows);

    // ?sura=5&ayat=10 → ওই সূরার ১০ নম্বর আয়াত
    if ($ayat !== null) {
        if ($ayat < 1 || $ayat > $count) {
            out(['error' => "সূরা $sura এ আয়াত আছে ১ থেকে $count পর্যন্ত"], 404);
        }
        out(clean($rows[$ayat - 1]));
    }

    // ?sura=5 → পুরো সূরা
    out([
        'suara_no' => $sura,
        'sura'     => $rows[0]['sura'],
        'count'    => $count,
        'data'     => array_map('clean', $rows),
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