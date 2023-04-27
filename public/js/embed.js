document.addEventListener("alpine:init", () => {
    Alpine.data("embed", () => ({
        view: "monthly",
        isShowingMonthly: true,
        isShowingYearly: false,
        isShowingMultiple: false,
        baseURL: window.baseURL,
        jsBaseURL: window.jsBaseURL,
        previewOptions: {
            title: "no",
            lang: "en",
            bookingInfo: "no",
            noOfMonths: 1,
            showLegend: "no",
            weekNumber: "no",
            firstDay: 0,
            startDate: "current",
            history: "yes",
        },
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

            this.$watch("previewOptions", (value) => {
                this.generateEmbedCode();
            });
        },

        generateEmbedCode() {
            const URL = this.generateParams(this.baseURL);
            const JS_URL = this.generateParams(this.jsBaseURL);
            this.codes.iframe = `<iframe src="${URL}" frameborder="0" width="100%" height="500px" style="border: 0; overflow: hidden;"></iframe>`;
            this.codes.script = `<script type="text/javascript" src="${JS_URL}"></script>`;

            this.codes.directLink = URL;
            this.codes.aTag = `<a target="_blank" href="${URL}">Availability Calendar</a>`;
        },

        generateParams(url) {
            if (url == "") return;

            let params = {};
            params.view = `?view=${this.view}`;
            params.lang = `&lang=${this.previewOptions.lang}`;
            params.title = `&title=${this.previewOptions.title}`;
            params.bookingInfo = `&booking_info=${this.previewOptions.bookingInfo}`;
            params.noOfMonths = `&no_of_months=${this.previewOptions.noOfMonths}`;
            params.showLegend = `&show_legend=${this.previewOptions.showLegend}`;
            params.weekNumber = `&week_number=${this.previewOptions.weekNumber}`;
            params.firstDay = `&first_day=${this.previewOptions.firstDay}`;
            params.startDate = `&start_date=${this.previewOptions.startDate}`;
            params.history = `&history=${this.previewOptions.history}`;

            if (this.view === "monthly" && this.previewOptions.startDate !== "current") {
                const [month, year] = this.previewOptions.startDate.split("-");
                params.month = `&month=${window.allMonths[month]}`;
                params.year = `&year=${year}`;
            }

            Object.keys(params).forEach((key) => {
                if (params[key] !== "" || params[key] !== undefined) {
                    url += params[key];
                }
            });

            return url;
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

        preview() {},
    })); 
});