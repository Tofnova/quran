/* ================= Config ================= */
const host = window.location.origin;
const API = host + "/api?id=";
const WATERMARK = localStorage.getItem("userName");   // https:// ছাড়া শুধু ডোমেইন দেখাবে
const TOTAL = 6236;
document.getElementById('url').innerHTML = window.location.host;
const THEMES = {
    emerald: { n: "এমারেল্ড গোল্ড", bg: "radial-gradient(circle at 50% 18%,rgba(255,255,255,.10),transparent 55%),linear-gradient(160deg,#075e47,#0b2a22 62%,#050f0b)", text: "#ffffff", sub: "#d3ebdf", accent: "#e8c862", pill: "rgba(0,0,0,.22)", sw: "linear-gradient(135deg,#075e47,#e8c862)" },
    midnight: { n: "মিডনাইট ব্লু", bg: "radial-gradient(circle at 50% 18%,rgba(147,197,253,.14),transparent 55%),linear-gradient(160deg,#16275a,#0c1533 62%,#050913)", text: "#ffffff", sub: "#d6e4ff", accent: "#9cc7ff", pill: "rgba(0,0,0,.25)", sw: "linear-gradient(135deg,#16275a,#9cc7ff)" },
    royal: { n: "রয়্যাল পার্পল", bg: "radial-gradient(circle at 50% 18%,rgba(251,191,36,.12),transparent 55%),linear-gradient(160deg,#4a0f7a,#24104d 62%,#0e0724)", text: "#ffffff", sub: "#eadcff", accent: "#f6c453", pill: "rgba(0,0,0,.25)", sw: "linear-gradient(135deg,#4a0f7a,#f6c453)" },
    blackgold: { n: "ব্ল্যাক গোল্ড", bg: "radial-gradient(circle at 50% 18%,rgba(212,175,55,.14),transparent 55%),linear-gradient(160deg,#1c1917,#0c0a09 65%,#000)", text: "#fdf6e3", sub: "#e7dcc0", accent: "#d9b445", pill: "rgba(212,175,55,.08)", sw: "linear-gradient(135deg,#1c1917,#d9b445)" },
    rose: { n: "রোজ ওয়াইন", bg: "radial-gradient(circle at 50% 18%,rgba(253,217,168,.14),transparent 55%),linear-gradient(160deg,#8a1538,#4c0a22 62%,#210510)", text: "#ffffff", sub: "#ffe2e8", accent: "#f7d6a0", pill: "rgba(0,0,0,.25)", sw: "linear-gradient(135deg,#8a1538,#f7d6a0)" },
    cream: { n: "ক্রিম লাইট", bg: "radial-gradient(circle at 50% 18%,rgba(255,255,255,.7),transparent 55%),linear-gradient(160deg,#fcf8ec,#f1e5c4 70%,#e6d5a8)", text: "#1f2a24", sub: "#3d4a40", accent: "#8b6212", pill: "rgba(139,98,18,.08)", sw: "linear-gradient(135deg,#fcf8ec,#8b6212)" }
};
const RATIOS = { square: { n: "স্কয়ার ১:১", h: 1080, i: "fa-regular fa-square" }, portrait: { n: "পোস্ট ৪:৫", h: 1350, i: "fa-regular fa-image" }, story: { n: "স্টোরি ৯:১৬", h: 1920, i: "fa-solid fa-mobile-screen" } };

const $ = id => document.getElementById(id);
const card = $("card");

let S = { id: 1, theme: "emerald", ratio: "square", arFont: "Amiri", bnFont: "Noto Serif Bengali", data: null };
try { Object.assign(S, JSON.parse(localStorage.getItem("ayatCardPrefs") || "{}")); } catch (e) { }
const savePrefs = () => { try { localStorage.setItem("ayatCardPrefs", JSON.stringify({ theme: S.theme, ratio: S.ratio, arFont: S.arFont, bnFont: S.bnFont })); } catch (e) { } };

/* ================= Helpers ================= */
const toBn = n => String(n).replace(/\d/g, d => "০১২৩৪৫৬৭৮৯"[d]);
const refText = d => d.sura ? `সূরা ${d.sura} — আয়াত ${toBn(d.ayat_no)}` : ("আয়াত #" + d.id);

function toast(msg, err) {
    const t = $("toast");
    t.innerHTML = `<i class="fa-solid ${err ? "fa-triangle-exclamation" : "fa-circle-check"}"></i>`;
    t.appendChild(document.createTextNode(msg));
    t.classList.toggle("err", !!err); t.classList.add("show");
    clearTimeout(toast._t); toast._t = setTimeout(() => t.classList.remove("show"), 2200);
}
function getAyatID() {
    const n = parseInt(location.hash.replace("#", ""));
    return (n >= 1 && n <= TOTAL) ? n : 1;
}
function gotoAyat(n) {
    n = Math.min(TOTAL, Math.max(1, parseInt(n) || 1));
    if (location.hash === "#" + n) loadAyat(); else location.hash = n;
    saveoldhash();
}
function patternURL(color) {
    const svg = `<svg xmlns="http://www.w3.org/2000/svg" width="90" height="90" viewBox="0 0 90 90"><g fill="none" stroke="${color}" stroke-width="1.2" stroke-opacity=".16"><rect x="22" y="22" width="46" height="46"/><rect x="22" y="22" width="46" height="46" transform="rotate(45 45 45)"/><circle cx="45" cy="45" r="9"/></g></svg>`;
    return `url("data:image/svg+xml,${encodeURIComponent(svg)}")`;
}

/* ================= Style ================= */
function applyTheme() {
    const t = THEMES[S.theme];
    card.style.setProperty("--bg", t.bg);
    card.style.setProperty("--text", t.text);
    card.style.setProperty("--sub", t.sub);
    card.style.setProperty("--accent", t.accent);
    card.style.setProperty("--pill", t.pill);
    $("pattern").style.backgroundImage = patternURL(t.accent);
    document.querySelectorAll(".swatch").forEach(b => b.classList.toggle("active", b.dataset.t === S.theme));
}
function applyRatio() {
    card.style.height = RATIOS[S.ratio].h + "px";
    document.querySelectorAll("[data-r]").forEach(b => b.classList.toggle("active", b.dataset.r === S.ratio));
}
function applyFonts() {
    $("arabic").style.fontFamily = `"${S.arFont}",Amiri,serif`;
    $("bismillah").style.fontFamily = `"${S.arFont}",Amiri,serif`;
    $("bangla").style.fontFamily = `"${S.bnFont}","Hind Siliguri",serif`;
    $("title").style.fontFamily = `"${S.bnFont}","Hind Siliguri",serif`;
    $("ref").style.fontFamily = `"${S.bnFont}","Hind Siliguri",serif`;
    $("arFont").value = S.arFont; $("bnFont").value = S.bnFont;
}
function scaleStage() {
    const wrap = $("stageWrap");
    const avail = wrap.parentElement.clientWidth;
    const s = Math.min(1, avail / 1080);
    const h = RATIOS[S.ratio].h;
    card.style.transform = `scale(${s})`;
    wrap.style.width = (1080 * s) + "px";
    wrap.style.height = (h * s) + "px";
}
async function waitFonts() {
    try {
        await Promise.all([
            document.fonts.load(`40px "${S.arFont}"`, $("arabic").textContent),
            document.fonts.load(`700 30px "${S.arFont}"`, $("arabic").textContent),
            document.fonts.load(`30px "${S.bnFont}"`, $("bangla").textContent || "অআক"),
            document.fonts.load(`600 26px Cinzel`, WATERMARK)
        ]);
        await document.fonts.ready;
    } catch (e) { }
}
/* Auto-fit: long ayat => font ছোট হবে, short ayat => বড় */
function fitText() {
    const len = ($("arabic").textContent || "").length;
    let a = len < 70 ? 70 : len < 140 ? 58 : len < 260 ? 48 : len < 420 ? 40 : 32;
    if (S.ratio === "story") a += 6;
    let b = Math.round(a * 0.62);
    const box = $("body"), content = $("content");
    for (let i = 0; i < 40; i++) {
        $("arabic").style.fontSize = a + "px";
        $("bangla").style.fontSize = b + "px";
        if (content.offsetHeight <= box.clientHeight) break;
        a -= 2; b = Math.max(16, b - 1.3);
        if (a < 18) break;
    }
}
async function render() {
    const d = S.data;
    if (d) {
        $("title").textContent = "কুরআনের আয়াত";
        $("arabic").textContent = d.ayat_arbic || "";
        $("bangla").textContent = d.ayat_bangla || "";
        document.getElementById('banglaedit').value=d.ayat_bangla;
        $("ref").textContent = refText(d);
    }
    $("wm").textContent = WATERMARK;
    $("wmBig").textContent = WATERMARK.toUpperCase() + "  •  " + WATERMARK.toUpperCase();
    applyTheme(); applyRatio(); applyFonts();
    await waitFonts();
    fitText();
    scaleStage();
}
function banclacng(){
    const banglaedit = document.getElementById('banglaedit').value;
    $("bangla").textContent= banglaedit;
}

/* ================= Data ================= */
async function loadAyat() {
    S.id = getAyatID();
    $("idInput").value = S.id;
    $("arabic").textContent = "লোড হচ্ছে...";
    $("bangla").textContent = "";
    $("ref").textContent = "";
    try {
        const res = await fetch(API + S.id);
        if (!res.ok) throw new Error("HTTP " + res.status);
        let ayat = await res.json();
        if (Array.isArray(ayat)) ayat = ayat[0];
        S.data = ayat;
        $("error").textContent = "";
        await render();
    } catch (err) {
        $("arabic").textContent = "আয়াত লোড করা যায়নি";
        $("error").textContent = "API সংযোগে সমস্যা হয়েছে — আবার চেষ্টা করুন";
        scaleStage();
    }
}

/* ================= Export / Share ================= */
async function makeBlob() {
    await waitFonts();
    const canvas = await html2canvas(card, {
        scale: 1, backgroundColor: null, useCORS: true, logging: false,
        width: 1080, height: RATIOS[S.ratio].h,
        onclone: doc => { const c = doc.getElementById("card"); c.style.transform = "none"; }
    });
    return new Promise(r => canvas.toBlob(r, "image/png", 1));
}
function fileName() { return "ayat-" + S.id + "-" + S.ratio + ".png"; }
function textToShare() {
    const d = S.data || {};
    return `${d.ayat_arbic || ""}\n\n${d.ayat_bangla || ""}\n\n— ${d.sura ? refText(d) : ""}\n${WATERMARK}`;
}
async function withBusy(btn, fn) {
    const old = btn.innerHTML; btn.disabled = true; btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i>অপেক্ষা করুন...';
    try { await fn(); } catch (e) { console.error(e); toast("সমস্যা হয়েছে, আবার চেষ্টা করুন", true); }
    btn.disabled = false; btn.innerHTML = old;
}
function saveBlob(blob) {
    const a = document.createElement("a");
    a.download = fileName(); a.href = URL.createObjectURL(blob);
    document.body.appendChild(a); a.click(); a.remove();
    setTimeout(() => URL.revokeObjectURL(a.href), 5000);
}
$("dl").onclick = e => withBusy(e.currentTarget, async () => {
    saveBlob(await makeBlob()); toast("ছবি ডাউনলোড হয়েছে");
});
$("shareImg").onclick = e => withBusy(e.currentTarget, async () => {
    const blob = await makeBlob();
    const file = new File([blob], fileName(), { type: "image/png" });
    if (navigator.canShare && navigator.canShare({ files: [file] })) {
        try { await navigator.share({ files: [file], title: "কুরআনের আয়াত", text: WATERMARK }); }
        catch (err) { if (err.name !== "AbortError") throw err; }
    } else {
        saveBlob(blob); toast("এই ব্রাউজারে সরাসরি শেয়ার নেই — ছবি ডাউনলোড হয়েছে");
    }
});
document.querySelectorAll("[data-s]").forEach(b => {
    b.onclick = () => {
        const url = encodeURIComponent(location.href);
        const txt = encodeURIComponent(textToShare());
        const links = {
            wa: "https://wa.me/?text=" + encodeURIComponent(textToShare() + "\n\n" + location.href),
            fb: "https://www.facebook.com/sharer/sharer.php?u=" + url,
            tg: "https://t.me/share/url?url=" + url + "&text=" + txt,
            x: "https://twitter.com/intent/tweet?text=" + encodeURIComponent((S.data && S.data.ayat_bangla || "") + "\n" + WATERMARK) + "&url=" + url
        };
        window.open(links[b.dataset.s], "_blank", "noopener");
    };
});
async function copy(text, ok) {
    try { await navigator.clipboard.writeText(text); }
    catch (e) {
        const t = document.createElement("textarea"); t.value = text; document.body.appendChild(t);
        t.select(); document.execCommand("copy"); t.remove();
    }
    toast(ok);
}
$("copyText").onclick = () => copy(textToShare(), "টেক্সট কপি হয়েছে");
$("copyLink").onclick = () => copy(location.href, "লিংক কপি হয়েছে");

/* ================= UI wiring ================= */
const themesEl = $("themes");
Object.entries(THEMES).forEach(([k, t]) => {
    const b = document.createElement("button");
    b.className = "swatch"; b.dataset.t = k; b.title = t.n; b.style.background = t.sw;
    b.onclick = () => { S.theme = k; savePrefs(); applyTheme(); };
    themesEl.appendChild(b);
});
const ratiosEl = $("ratios");
Object.entries(RATIOS).forEach(([k, r]) => {
    const b = document.createElement("button");
    b.className = "chip"; b.dataset.r = k; b.innerHTML = `<i class="${r.i}"></i>${r.n}`;
    b.onclick = async () => { S.ratio = k; savePrefs(); applyRatio(); await waitFonts(); fitText(); scaleStage(); };
    ratiosEl.appendChild(b);
});
$("arFont").onchange = async e => { S.arFont = e.target.value; savePrefs(); applyFonts(); await waitFonts(); fitText(); };
$("bnFont").onchange = async e => { S.bnFont = e.target.value; savePrefs(); applyFonts(); await waitFonts(); fitText(); };

$("prev").onclick = () => gotoAyat(S.id - 1);
$("next").onclick = () => gotoAyat(S.id + 1);
$("rand").onclick = () => gotoAyat(Math.floor(Math.random() * TOTAL) + 1);
$("go").onclick = () => gotoAyat($("idInput").value);
$("idInput").addEventListener("keydown", e => { if (e.key === "Enter") gotoAyat(e.target.value); });

window.addEventListener("hashchange", loadAyat);
window.addEventListener("resize", scaleStage);

applyTheme(); applyRatio(); applyFonts(); scaleStage();
loadAyat();

const popup = document.getElementById("popup");
const input = document.getElementById("name");

function getName() {
    return (localStorage.getItem("userName") || "").trim();
}

function checkName() {
    if (getName()) {
        popup.style.display = "none";
    } else {
        popup.style.display = "flex";
        input.focus();
    }
}

function savename() {
    const name = input.value.trim();

    if (name.length < 2) {
        input.classList.add("error");
        input.placeholder = "নাম লিখো (কমপক্ষে ২ অক্ষর)";
        input.focus();
        return;
    }

    localStorage.setItem("userName", name);
    location.reload();
}

input.addEventListener("input", () => input.classList.remove("error"));
input.addEventListener("keydown", e => { if (e.key === "Enter") savename(); });

checkName();
function saveoldhash() {
    const myhsash = window.location.hash;
    localStorage.setItem("ii", myhsash);
}

 window.location.href=window.location.origin+localStorage.getItem("ii");
