<?php
$page  = 'docs';
$title = 'API ডকুমেন্টেশন — কুরআন API';
$desc  = 'কুরআন API ব্যবহারের নিয়ম: এন্ডপয়েন্ট, প্যারামিটার, রেসপন্স, এরর এবং কোড উদাহরণ — সবই বাংলায়।';
require_once '../header.php';
?>
<div class="docs">

    <header class="docs-hero">
        <h1><i class="fa-solid fa-code"></i> কুরআন API ডকুমেন্টেশন</h1>
        <p>আরবি ও বাংলা অনুবাদসহ কুরআনের <b>৬২৩৬</b>টি আয়াত, ১১৪টি সূরা — ফ্রি, কোনো API key লাগে না।</p>
        <div class="docs-toc">
            <a href="#intro">পরিচিতি</a>
            <a href="#endpoints">এন্ডপয়েন্ট</a>
            <a href="#fields">রেসপন্সের ফিল্ড</a>
            <a href="#examples">রেসপন্স উদাহরণ</a>
            <a href="#errors">এরর</a>
            <a href="#code">কোড উদাহরণ</a>
            <a href="#try">লাইভ টেস্ট</a>
        </div>
    </header>

    <section class="panel" id="intro">
        <h3><i class="fa-solid fa-circle-info"></i>পরিচিতি</h3>
        <p>বেস URL:</p>
        <div class="code"><pre><code><?= $h($base) ?>/api</code></pre><button class="copy" type="button"><i class="fa-regular fa-copy"></i>কপি</button></div>
        <ul class="docs-list">
            <li>শুধু <b>GET</b> রিকোয়েস্ট চলে, রেসপন্স সবসময় <b>JSON</b> (UTF-8)।</li>
            <li><code>/api.json</code> দিয়েও একই কাজ হয়, যেমন <code>/api.json?id=100</code>।</li>
            <li><b>CORS খোলা</b> — যেকোনো ওয়েবসাইট বা অ্যাপ থেকে সরাসরি কল করা যায়।</li>
            <li>ক্যাশ বন্ধ, তাই <code>/api</code> রিলোড দিলেই নতুন র‍্যান্ডম আয়াত আসে।</li>
        </ul>
    </section>

    <section class="panel" id="endpoints">
        <h3><i class="fa-solid fa-link"></i>এন্ডপয়েন্ট</h3>

        <div class="ep">
            <div class="ep-head"><span class="badge">GET</span><code>/api</code></div>
            <p>কোনো প্যারামিটার ছাড়া — <b>র‍্যান্ডম ১টা আয়াত</b>।</p>
            <button class="try" type="button" data-try="/api"><i class="fa-solid fa-play"></i>চেষ্টা করুন</button>
        </div>

        <div class="ep">
            <div class="ep-head"><span class="badge">GET</span><code>/api?id=<i>নম্বর</i></code></div>
            <p>নির্দিষ্ট নম্বরের আয়াত। <code>id</code> হবে ১ থেকে ৬২৩৬ — পুরো কুরআনের ক্রমিক নম্বর।</p>
            <button class="try" type="button" data-try="/api?id=100"><i class="fa-solid fa-play"></i>/api?id=100</button>
        </div>

        <div class="ep">
            <div class="ep-head"><span class="badge">GET</span><code>/api?sura=<i>নম্বর</i></code></div>
            <p>একটা সূরার <b>সব আয়াত</b>। <code>sura</code> হবে ১ থেকে ১১৪।</p>
            <button class="try" type="button" data-try="/api?sura=112"><i class="fa-solid fa-play"></i>/api?sura=112</button>
        </div>

        <div class="ep">
            <div class="ep-head"><span class="badge">GET</span><code>/api?sura=<i>নম্বর</i>&amp;ayat=<i>নম্বর</i></code></div>
            <p>নির্দিষ্ট সূরার নির্দিষ্ট আয়াত। এখানে <code>ayat</code> হলো ওই সূরার <b>ভেতরের</b> আয়াত নম্বর (যেমন সূরা বাকারার ২৫৫ নম্বর আয়াত)।</p>
            <button class="try" type="button" data-try="/api?sura=2&ayat=255"><i class="fa-solid fa-play"></i>/api?sura=2&amp;ayat=255</button>
        </div>

        <div class="ep">
            <div class="ep-head"><span class="badge">GET</span><code>/api?f=<i>শুরু</i>&amp;t=<i>শেষ</i></code></div>
            <p><code>id</code> ধরে <b>শুরু থেকে শেষ পর্যন্ত</b> সব আয়াত — দুই প্রান্তের আয়াতসহ। যেমন <code>f=120&amp;t=200</code> দিলে ৮১টা আয়াত আসবে। শুধু <code>f</code> দিলে শেষ পর্যন্ত, শুধু <code>t</code> দিলে ১ থেকে।</p>
            <button class="try" type="button" data-try="/api?f=120&t=125"><i class="fa-solid fa-play"></i>/api?f=120&amp;t=125</button>
        </div>

        <p class="note"><i class="fa-solid fa-circle-info"></i> একসাথে একাধিক প্যারামিটার দিলে অগ্রাধিকার: <b>f/t</b> → <b>sura (+ayat)</b> → <b>id</b> → র‍্যান্ডম। <code>ayat</code> একা দেওয়া যায় না, সাথে <code>sura</code> লাগবে।</p>
    </section>

    <section class="panel" id="fields">
        <h3><i class="fa-solid fa-table-list"></i>রেসপন্সের ফিল্ড</h3>
        <div class="table-wrap">
            <table>
                <thead><tr><th>ফিল্ড</th><th>ধরন</th><th>মানে</th></tr></thead>
                <tbody>
                    <tr><td><code>id</code></td><td>সংখ্যা</td><td>পুরো কুরআনে আয়াতের ক্রমিক নম্বর (১–৬২৩৬)</td></tr>
                    <tr><td><code>suara_no</code></td><td>সংখ্যা</td><td>সূরার নম্বর (১–১১৪)</td></tr>
                    <tr><td><code>sura</code></td><td>লেখা</td><td>সূরার নাম (বাংলায়)</td></tr>
                    <tr><td><code>ayat_no</code></td><td>সংখ্যা</td><td>ওই সূরার ভেতরে আয়াতের নম্বর</td></tr>
                    <tr><td><code>ayat_bangla</code></td><td>লেখা</td><td>আয়াতের বাংলা অনুবাদ</td></tr>
                    <tr><td><code>ayat_bangla_u</code></td><td>লেখা</td><td>বাংলা উচ্চারণ — <i>এখনো খালি (<code>""</code>)</i></td></tr>
                    <tr><td><code>ayat_arbic</code></td><td>লেখা</td><td>আরবি আয়াত</td></tr>
                </tbody>
            </table>
        </div>
        <p class="note"><i class="fa-solid fa-circle-info"></i> একটা আয়াত হলে সরাসরি object আসে। একাধিক আয়াত হলে <code>data</code> নামের array-তে আসে, সাথে <code>count</code> থাকে।</p>
    </section>

    <section class="panel" id="examples">
        <h3><i class="fa-solid fa-file-code"></i>রেসপন্স উদাহরণ</h3>

        <h4>/api?id=1 &nbsp;(এবং র‍্যান্ডমও একই গঠনের)</h4>
        <div class="code"><pre><code>{
    "id": 1,
    "suara_no": 1,
    "sura": "আল-ফাতিহা",
    "ayat_no": 1,
    "ayat_bangla": "শুরু করছি আল্লাহর নামে যিনি পরম করুণাময়, অতি দয়ালু।",
    "ayat_bangla_u": "",
    "ayat_arbic": "بِسْمِ ٱللَّهِ ٱلرَّحْمَٰنِ ٱلرَّحِيمِ"
}</code></pre><button class="copy" type="button"><i class="fa-regular fa-copy"></i>কপি</button></div>

        <h4>/api?sura=112 &nbsp;(পুরো সূরা)</h4>
        <div class="code"><pre><code>{
    "suara_no": 112,
    "sura": "আল-ইখলাস",
    "count": 4,
    "data": [
        {
            "id": 6222,
            "suara_no": 112,
            "sura": "আল-ইখলাস",
            "ayat_no": 1,
            "ayat_bangla": "বলুন, তিনি আল্লাহ, এক,",
            "ayat_bangla_u": "",
            "ayat_arbic": "قُلْ هُوَ ٱللَّهُ أَحَدٌ"
        },
        {
            "id": 6223,
            "suara_no": 112,
            "sura": "আল-ইখলাস",
            "ayat_no": 2,
            "ayat_bangla": "আল্লাহ অমুখাপেক্ষী,",
            "ayat_bangla_u": "",
            "ayat_arbic": "ٱللَّهُ ٱلصَّمَدُ"
        },
        {
            "id": 6224,
            "suara_no": 112,
            "sura": "আল-ইখলাস",
            "ayat_no": 3,
            "ayat_bangla": "তিনি কাউকে জন্ম দেননি এবং কেউ তাকে জন্ম দেয়নি",
            "ayat_bangla_u": "",
            "ayat_arbic": "لَمْ يَلِدْ وَلَمْ يُولَدْ"
        },
        {
            "id": 6225,
            "suara_no": 112,
            "sura": "আল-ইখলাস",
            "ayat_no": 4,
            "ayat_bangla": "এবং তার সমতুল্য কেউ নেই।",
            "ayat_bangla_u": "",
            "ayat_arbic": "وَلَمْ يَكُن لَّهُۥ كُفُوًا أَحَدٌۢ"
        }
    ]
}</code></pre><button class="copy" type="button"><i class="fa-regular fa-copy"></i>কপি</button></div>

        <h4>/api?sura=112&amp;ayat=1 &nbsp;(সূরার একটা আয়াত)</h4>
        <div class="code"><pre><code>{
    "id": 6222,
    "suara_no": 112,
    "sura": "আল-ইখলাস",
    "ayat_no": 1,
    "ayat_bangla": "বলুন, তিনি আল্লাহ, এক,",
    "ayat_bangla_u": "",
    "ayat_arbic": "قُلْ هُوَ ٱللَّهُ أَحَدٌ"
}</code></pre><button class="copy" type="button"><i class="fa-regular fa-copy"></i>কপি</button></div>

        <h4>/api?f=1&amp;t=2 &nbsp;(id ধরে range)</h4>
        <div class="code"><pre><code>{
    "from": 1,
    "to": 2,
    "count": 2,
    "data": [
        {
            "id": 1,
            "suara_no": 1,
            "sura": "আল-ফাতিহা",
            "ayat_no": 1,
            "ayat_bangla": "শুরু করছি আল্লাহর নামে যিনি পরম করুণাময়, অতি দয়ালু।",
            "ayat_bangla_u": "",
            "ayat_arbic": "بِسْمِ ٱللَّهِ ٱلرَّحْمَٰنِ ٱلرَّحِيمِ"
        },
        {
            "id": 2,
            "suara_no": 1,
            "sura": "আল-ফাতিহা",
            "ayat_no": 2,
            "ayat_bangla": "যাবতীয় প্রশংসা আল্লাহ তাআলার যিনি সকল সৃষ্টি জগতের পালনকর্তা।",
            "ayat_bangla_u": "",
            "ayat_arbic": "ٱلْحَمْدُ لِلَّهِ رَبِّ ٱلْعَٰلَمِينَ"
        }
    ]
}</code></pre><button class="copy" type="button"><i class="fa-regular fa-copy"></i>কপি</button></div>
    </section>

    <section class="panel" id="errors">
        <h3><i class="fa-solid fa-triangle-exclamation"></i>এরর</h3>
        <p>কিছু ভুল হলে নিচের মতো JSON আসে, সাথে HTTP স্ট্যাটাস কোড:</p>
        <div class="code"><pre><code>{
    "error": "id অবশ্যই ১ থেকে 6236 এর মধ্যে হতে হবে"
}</code></pre></div>
        <div class="table-wrap">
            <table>
                <thead><tr><th>কোড</th><th>কখন হয়</th></tr></thead>
                <tbody>
                    <tr><td><code>400</code></td><td><code>f</code>/<code>t</code> সংখ্যা না হলে বা <code>f</code> বড় হলে; <code>sura</code> ছাড়া <code>ayat</code> দিলে</td></tr>
                    <tr><td><code>404</code></td><td><code>id</code>, <code>sura</code> বা <code>ayat</code> সীমার বাইরে হলে</td></tr>
                    <tr><td><code>500</code></td><td>সার্ভারে <code>quran.json</code> না পাওয়া গেলে</td></tr>
                </tbody>
            </table>
        </div>
    </section>

    <section class="panel" id="code">
        <h3><i class="fa-solid fa-terminal"></i>কোড উদাহরণ</h3>

        <details open>
            <summary>JavaScript</summary>
            <div class="code"><pre><code>const res = await fetch("<?= $h($base) ?>/api?sura=112");
const data = await res.json();

console.log(data.sura, data.count);
data.data.forEach(a =&gt; console.log(a.ayat_no, a.ayat_arbic, a.ayat_bangla));</code></pre><button class="copy" type="button"><i class="fa-regular fa-copy"></i>কপি</button></div>
        </details>

        <details>
            <summary>PHP</summary>
            <div class="code"><pre><code>$json  = file_get_contents("<?= $h($base) ?>/api?id=100");
$ayat  = json_decode($json, true);

echo $ayat['sura'] . ' — ' . $ayat['ayat_bangla'];</code></pre><button class="copy" type="button"><i class="fa-regular fa-copy"></i>কপি</button></div>
        </details>

        <details>
            <summary>Python</summary>
            <div class="code"><pre><code>import requests

r = requests.get("<?= $h($base) ?>/api", params={"sura": 2, "ayat": 255})
print(r.json()["ayat_bangla"])</code></pre><button class="copy" type="button"><i class="fa-regular fa-copy"></i>কপি</button></div>
        </details>

        <details>
            <summary>cURL</summary>
            <div class="code"><pre><code>curl "<?= $h($base) ?>/api?f=120&amp;t=125"</code></pre><button class="copy" type="button"><i class="fa-regular fa-copy"></i>কপি</button></div>
        </details>
    </section>

    <section class="panel" id="try">
        <h3><i class="fa-solid fa-flask"></i>লাইভ টেস্ট</h3>
        <p>নিচে লিংক লিখে "পাঠান" চাপুন, অথবা উপরের যেকোনো "চেষ্টা করুন" বাটন চাপুন।</p>
        <div class="row">
            <input type="text" id="t-url" class="grow url-input" value="/api?id=100" spellcheck="false" autocomplete="off">
            <button class="btn" id="t-go" type="button"><i class="fa-solid fa-paper-plane"></i>পাঠান</button>
        </div>
        <div id="t-status" class="t-status"></div>
        <div class="code"><pre><code id="t-out">এখানে রেসপন্স দেখা যাবে...</code></pre></div>
    </section>

</div>

<script>
(function () {
    var out = document.getElementById('t-out'),
        st = document.getElementById('t-status'),
        inp = document.getElementById('t-url');

    async function run() {
        var p = inp.value.trim();
        if (p.indexOf('/api') !== 0) { st.textContent = 'লিংক অবশ্যই /api দিয়ে শুরু হতে হবে'; return; }
        st.textContent = 'লোড হচ্ছে...'; out.textContent = '';
        try {
            var t0 = performance.now();
            var r = await fetch(p);
            var txt = await r.text();
            st.textContent = 'স্ট্যাটাস: ' + r.status + ' · ' + Math.round(performance.now() - t0) + ' ms';
            try { txt = JSON.stringify(JSON.parse(txt), null, 2); } catch (e) { }
            if (txt.length > 20000) txt = txt.slice(0, 20000) + '\n\n... (বাকিটা বড় বলে এখানে দেখানো হয়নি)';
            out.textContent = txt;
        } catch (e) {
            st.textContent = 'সংযোগে সমস্যা হয়েছে';
        }
    }

    document.getElementById('t-go').onclick = run;
    inp.addEventListener('keydown', function (e) { if (e.key === 'Enter') run(); });

    document.querySelectorAll('.try').forEach(function (b) {
        b.onclick = function () {
            inp.value = b.dataset.try;
            document.getElementById('try').scrollIntoView({ behavior: 'smooth' });
            run();
        };
    });

    document.querySelectorAll('.copy').forEach(function (b) {
        b.onclick = async function () {
            var text = b.parentElement.querySelector('pre').innerText;
            try { await navigator.clipboard.writeText(text); }
            catch (e) {
                var t = document.createElement('textarea'); t.value = text; document.body.appendChild(t);
                t.select(); document.execCommand('copy'); t.remove();
            }
            var old = b.innerHTML; b.innerHTML = '<i class="fa-solid fa-check"></i>কপি হয়েছে';
            setTimeout(function () { b.innerHTML = old; }, 1500);
        };
    });
})();
</script>

<?php require_once '../footer.php'; ?>
