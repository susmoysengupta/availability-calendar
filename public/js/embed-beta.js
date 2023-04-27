document.addEventListener("alpine:init", () => {
    Alpine.data("embed_beta", () => ({
        view: "monthly",
        baseURL: window.baseURL,
        jsBaseURL: window.jsBaseURL,

        codes: {
            iframe: "",
            script: "",
            directLink: "",
            aTag: "",
            popup: "",
        },

        init() {
            this.generateEmbedCode();

            this.$watch("view", (value) => {
                if (value === "monthly") {
                    this.isShowingMonthly = true;
                    this.isShowingYearly = this.isShowingMultiple = false;
                } else if (value === "yearly") {
                    this.isShowingYearly = true;
                    this.isShowingMonthly = this.isShowingMultiple = false;
                } else if (value === "multiple") {
                    this.isShowingMultiple = true;
                    this.isShowingMonthly = this.isShowingYearly = false;
                }
            });
        },

        generateEmbedCode() {
            this.codes.iframe = `<iframe src="${this.baseURL}" frameborder="0" width="100%" height="550" style="border: 0; overflow: hidden;"></iframe>`;
            this.codes.script = `<script type="text/javascript" src="${this.jsBaseURL}"></script>`;

            this.codes.directLink = this.baseURL;
            this.codes.aTag = `<a target="_blank" href="${this.baseURL}">Availability Calendar</a>`;

            this.codes.popup = `<a href="javascript:void(0)" onclick="window.open('${this.baseURL}', '_blank', 'width=500,height=600')">Availability Calendar</a>`;
        },

        copyToClipboard(text) {
            if (!text) return;
            const el = document.createElement("textarea");
            el.value = text;
            document.body.appendChild(el);
            el.select();
            document.execCommand("copy");
            document.body.removeChild(el);
        },

        preview: function() {
            window.open(this.baseURL, "_blank", "width=500,height=600");
        },
    })); 
});