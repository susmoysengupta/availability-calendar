document.addEventListener("alpine:init", () => {
    Alpine.data("syncedCalendar", () => ({
        calendarId: window.calendar ? window.calendar.id : null,
        organizationId: window.organizationId,
        months: window.months,

        days: [],
        monthYears: [],
        currMonthYear: "",
        
        calendar: [],
        calendarDays: {},
        calendarMonthYears: [],

        isCalendarLoading: false,

        init: function() {
            this.changeCalendar(new Date());

            this.$watch("currMonthYear", (newValue) => {
                this.changeCalendar(this.getDate(newValue));
            });
        },

        changeCalendar: function(date) {
            this.generateNextMonthYears(date);
            this.getCalendar();
        },

        generateNextMonthYears: function(date, numberOfMonths = 12) {
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

        getDate: function(dateString) {
            const [month, year] = (dateString ?? this.currMonthYear).split("-");
            return new Date(year, this.months.indexOf(month));
        },

        showPreviousMonth: function() {
            const date = this.getDate();
            date.setMonth(date.getMonth() - 1);
            this.changeCalendar(date);
        },

        showNextMonth: function() {
            const date = this.getDate();
            date.setMonth(date.getMonth() + 1);
            this.changeCalendar(date);
        },

        getMonthYear: function(date) {
            const month = this.months[date.getMonth()];
            const year = date.getFullYear();
            return `${month.toLowerCase()}-${year}`;
        },

        getCalendar: function() {
            if (this.calendarId == null || this.organizationId == null || this.currMonthYear == null) {
                return;
            }

            this.isCalendarLoading = true;

            this.calendarMonthYears = [
                this.currMonthYear,
                this.getMonthYear(
                    new Date(
                        this.getDate(this.currMonthYear).setMonth(
                            this.getDate(this.currMonthYear).getMonth() + 1
                        )
                    )
                ),
                this.getMonthYear(
                    new Date(
                        this.getDate(this.currMonthYear).setMonth(
                            this.getDate(this.currMonthYear).getMonth() + 2
                        )
                    )
                ),
            ];

            this.calendarDays = {};
            this.days = [];
            
            this.calendarMonthYears.forEach((monthYear) => {
                const BASE_URI = `/api/calendars/${this.calendarId}`;
                const MONTH_YEAR = `?month_year=${monthYear}`;
                const ORGANIZATION_ID = `&organization_id=${this.organizationId}`;
                const URI = BASE_URI + MONTH_YEAR + ORGANIZATION_ID;

                axios
                    .get(URI)
                    .then(({ data }) => {
                        if (this.days.length === 0) this.days = data.days;
                        this.calendarDays[monthYear] = data.weekWiseDays;
                    })
                    .finally(() => {
                        this.isCalendarLoading = false;
                    });
            });
        },
    }));
});
