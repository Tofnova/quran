# কুরআন API

আরবি ও বাংলা অনুবাদসহ কুরআনের ৬২৩৬টি আয়াতের ফ্রি JSON API, সাথে আয়াতের ছবি (PNG) বানানোর টুল।

## ফাইল কাঠামো

| ফাইল | কাজ |
|---|---|
| `index.php` | হোম পেজ (আয়াতের কার্ড বানানোর টুল) |
| `home.php` | হোম পেজের HTML |
| `docs.php` | API ডকুমেন্টেশন পেজ (`/docs`) |
| `header.php` / `footer.php` | সব পেজের মাথা ও পা (আইকন, নেভবার, মেটা ট্যাগ) |
| `api/index.php` | API (`/api`) |
| `quran.json` | সব আয়াতের ডেটা |
| `script.js` | কার্ড তৈরি, ডাউনলোড ও শেয়ারের কোড |
| `style.css` | স্টাইল |
| `.htaccess` | `/api`, `/api.json`, `/docs` এর রাউটিং (Apache) |

## API ব্যবহার

| URL | কাজ |
|---|---|
| `/api` | র‍্যান্ডম ১টা আয়াত |
| `/api?id=100` | ১০০ নম্বর আয়াত (১–৬২৩৬) |
| `/api?sura=5` | ৫ নম্বর সূরার সব আয়াত |
| `/api?sura=5&ayat=10` | ৫ নম্বর সূরার ১০ নম্বর আয়াত |
| `/api?f=120&t=200` | id ১২০ থেকে ২০০ পর্যন্ত (দুটোই সহ) |

বিস্তারিত উদাহরণ ও লাইভ টেস্ট: `/docs`

## আয়াতের ফরম্যাট

```json
{
    "id": 1,
    "suara_no": 1,
    "sura": "আল-ফাতিহা",
    "ayat_no": 1,
    "ayat_bangla": "...",
    "ayat_bangla_u": "",
    "ayat_arbic": "..."
}
```

## চালানোর নিয়ম

PHP ৭.৪+ ও Apache (`mod_rewrite` চালু) লাগবে। Nginx হলে `.htaccess` কাজ করবে না, তখন এই rewrite দিন:

```
location = /api  { rewrite ^ /api/index.php last; }
location = /docs { rewrite ^ /docs.php last; }
```
