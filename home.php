<div class="w100 flex center medel">
    <div class="card">
        <p class="ar" id="ar">লোড হচ্ছে...</p>
        <p class="bn" id="bn"></p>
        <div class="info" id="info"></div>
        <div class="flex beet">
            <div>
                <button onclick="load()">নতুন আয়াত</button>
            </div>
            <div>
                <button>কোড কপি করুন</button>
            </div>
        </div>

        <style>
            .code pre {
                margin: 0;
                border-radius: 10px;
                overflow-x: auto;
                font-size: 14px;
                line-height: 1.6;
                text-align: left;
                /* এটা যোগ করুন */
                white-space: pre;
                /* এটাও */
                border-radius: 10px;
            }

            .code pre code.hljs {
                padding: 16px;
                display: block;
                text-align: left;
                /* এটাও */
                font-family: "Fira Code", Consolas, monospace;
                tab-size: 4;
            }
        </style>

        <div class="code">
            <pre>
    <code class="language-javascript">
        async function load() {
    try {
        const d = await (await fetch('/api?_=' + Date.now())).json();
        ar.textContent = d.ayat_Arbinc;
        bn.textContent = d.ayat_bangla;
        info.textContent = d.ayat_detels + ' (id: ' + d.id + ')';
    } catch (e) {
        ar.textContent = 'API থেকে ডেটা আনা যায়নি';
    }
}
load();
</code>
</pre>
        </div>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/highlight.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/prettier@3.3.3/standalone.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/prettier@3.3.3/plugins/babel.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/prettier@3.3.3/plugins/estree.js"></script>
        <script>
            document.querySelectorAll('pre code').forEach(async (el) => {
                try {
                    el.textContent = await prettier.format(el.textContent, {
                        parser: 'babel',
                        plugins: prettierPlugins,
                        tabWidth: 4,
                        singleQuote: true
                    });
                } catch (e) { }
                hljs.highlightElement(el);
            });

            async function load() {
                try {
                    const d = await (await fetch('/api?_=' + Date.now())).json();
                    ar.textContent = d.ayat_Arbinc;
                    bn.textContent = d.ayat_bangla;
                    info.textContent = d.ayat_detels + ' (id: ' + d.id + ')';
                } catch (e) {
                    ar.textContent = 'API থেকে ডেটা আনা যায়নি';
                }
            }
            load();
        </script>
    </div>