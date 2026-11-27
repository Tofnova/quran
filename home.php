<div class="darkBox" id="popup">
  <div class="popup">
    <br>
    <span>Input your name</span><br>
    <input id="name" type="text" placeholder="Your Name">
    <br>
    <div class="flex center medel">
      <button onclick="savename()" class="inbtn">
        Save
      </button>
    </div>
    <small>
      This name is a Photo , photocard and website title use! Do not use other way
    </small>
  </div>
</div>
<div class="container">
  <!-- Preview -->
  <div class="stp">
    <div class="stageWrap" id="stageWrap">
      <div id="card">
        <div class="pattern" id="pattern"></div>
        <div class="wmBig" id="wmBig"></div>
        <div class="frame"></div>
        <div class="frame2"></div>
        <span class="corner c1"></span><span class="corner c2"></span>
        <span class="corner c3"></span><span class="corner c4"></span>

        <div class="inner">
          <div id="bismillah">بِسْمِ ٱللَّهِ ٱلرَّحْمَٰنِ ٱلرَّحِيمِ</div>
          <div id="title">কুরআনের আয়াত</div>
          <div class="divider"></div>

          <div id="body">
            <div id="content">
              <div id="arabic" lang="ar">লোড হচ্ছে...</div>
              <div class="orn"></div>
              <div id="bangla"></div>
            </div>
          </div>
          <div id="ref"></div>
          <div class="foot"><span class="line"></span><span class="wm" id="wm"></span><span class="line"></span></div>
          <div class="flex beet w100x">
            <div></div>
            <div id="url"></div>
          </div>
        </div>
      </div>
    </div>
    <div id="error"></div>
  </div>
  <div class="stp">
    <!-- Navigation -->
    <div class="panel">
      <h3><i class="fa-solid fa-book-quran"></i>আয়াত নম্বর (১ – ৬২৩৬)</h3>
      <div class="row">
        <button class="chip" id="prev"><i class="fa-solid fa-chevron-left"></i>আগের</button>
        <input type="number" id="idInput" min="1" max="6236" value="1">
        <button class="chip" id="go"><i class="fa-solid fa-magnifying-glass"></i>যান</button>
        <button class="chip" id="next">পরের<i class="fa-solid fa-chevron-right" style="margin:0 0 0 8px"></i></button>
        <button class="chip" id="rand"><i class="fa-solid fa-shuffle"></i>র‍্যান্ডম</button>
      </div>
    </div>

    <!-- Style -->
    <div class="panel">

      <h3><i class="fa-solid fa-palette"></i>থিম</h3>
      <div class="row" id="themes"></div>

      <h3 style="margin-top:14px"><i class="fa-solid fa-expand"></i>ছবির সাইজ</h3>
      <div class="row" id="ratios"></div>

      <h3 style="margin-top:14px"><i class="fa-solid fa-font"></i>ফন্ট</h3>
      <div class="row">
        <select id="arFont" class="grow">
          <option value="Amiri">আরবি: Amiri</option>
          <option value="Scheherazade New">আরবি: Scheherazade</option>
          <option value="Noto Naskh Arabic">আরবি: Noto Naskh</option>
        </select>
        <select id="bnFont" class="grow">
          <option value="Noto Serif Bengali">বাংলা: Noto Serif</option>
          <option value="Hind Siliguri">বাংলা: Hind Siliguri</option>
          <option value="Tiro Bangla">বাংলা: Tiro Bangla</option>
        </select>
      </div>

      <h3 style="margin-top:14px"><i class="fa-regular fa-pen-to-square"></i>বাংলা সম্পদানা</h3>
      <div class="row">
        <textarea rows="12" name="textare" id="banglaedit" oninput="banclacng()"></textarea>
      </div>

    </div>

    <!-- Share -->
    <div class="panel">
      <h3><i class="fa-solid fa-share-nodes"></i>শেয়ার ও ডাউনলোড</h3>
      <div class="row">
        <button class="btn grow" id="dl"><i class="fa-solid fa-download"></i>PNG ডাউনলোড</button>
        <button class="btn gold grow" id="shareImg"><i class="fa-solid fa-image"></i>ছবি শেয়ার</button>
      </div>
      <div class="row" style="margin-top:8px">
        <button class="btn wa grow" data-s="wa"><i class="fa-brands fa-whatsapp"></i>WhatsApp</button>
        <button class="btn fb grow" data-s="fb"><i class="fa-brands fa-facebook-f"></i>Facebook</button>
        <button class="btn tg grow" data-s="tg"><i class="fa-brands fa-telegram"></i>Telegram</button>
        <button class="btn x grow" data-s="x"><i class="fa-brands fa-x-twitter"></i>X</button>
      </div>
      <div class="row" style="margin-top:8px">
        <button class="btn soft grow" id="copyText"><i class="fa-regular fa-copy"></i>টেক্সট কপি</button>
        <button class="btn soft grow" id="copyLink"><i class="fa-solid fa-link"></i>লিংক কপি</button>
      </div>
    </div>
  </div>

</div>