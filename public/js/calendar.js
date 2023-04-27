document.addEventListener("alpine:init", () => {
    Alpine.data("calendar_embed", () => ({
        calendarId: window.calendar ? window.calendar.id : null,
        months: window.months,
        days: [],
        monthYears: [],
        currMonthYear: "",
        legendColors: [],
        calendar: [],
        calendarDays: [],
        isCalendarLoading: false,

        init() {
            this.changeCalendar(new Date());

            this.$watch("currMonthYear", (newValue) => {
                this.changeCalendar(this.getDate(newValue));
            });
        },

        changeCalendar(date) {
            this.generateNextMonthYears(date);
            this.getCalendar();
        },

        generateNextMonthYears(date, numberOfMonths = 12) {
            const fromMonth = date.getMonth();
            const fromYear = date.getFullYear();
            const toMonth = fromMonth + numberOfMonths;
            this.currMonthYear = `${this.months[
                fromMonth
            ].toLowerCase()}-${fromYear}`;

            this.monthYears = [];
            const monthsInYear = 12;
            for (let i = fromMonth; i < toMonth; i++) {
                const monthNo = i % monthsInYear;
                const month = this.months[monthNo].toLowerCase();
                const year = fromYear + (i - monthNo) / monthsInYear;
                this.monthYears.push({
                    value: `${month}-${year}`,
                    label: `${month} ${year}`,
                });
            }
        },

        getDate(dateString) {
            const [month, year] = (dateString ?? this.currMonthYear).split("-");
            return new Date(year, this.months.indexOf(month));
        },

        showPreviousMonth() {
            const date = this.getDate();
            date.setMonth(date.getMonth() - 1);
            this.changeCalendar(date);
        },

        showNextMonth() {
            const date = this.getDate();
            date.setMonth(date.getMonth() + 1);
            this.changeCalendar(date);
        },

        getCalendar() {
            if (this.calendarId == null || this.currMonthYear == null) {
                return;
            }
            this.isCalendarLoading = true;
            const BASE_URI = `/api/public/calendars/${this.calendarId}`;
            const MONTH_YEAR = `?month_year=${this.currMonthYear}`;
            const URI = BASE_URI + MONTH_YEAR;
            axios
                .get(URI)
                .then(({ data }) => {
                    this.calendar = data;
                    this.calendarDays = this.calendar.weekWiseDays;
                    this.days = this.calendar.days;
                })
                .finally(() => {
                    this.isCalendarLoading = false;
                });
        },
    }));
});
