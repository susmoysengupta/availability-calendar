document.addEventListener("alpine:init", () => {
    Alpine.data("calendar", () => ({
        calendarId: window.calendar ? window.calendar.id : null,
        organizationId: window.organizationId,
        legends: window.legends,
        months: window.months,
        
        days: [],
        monthYears: [],
        currMonthYear: "",
        legendColors: [],
        calendar: [],
        calendarDays: [],

        isCalendarLoading: false,
        isQuickEditLoading: false,

        quickEdit: {
            from: "",
            to: "",
            legend: "",
            remarks: "",
            minDate: "",
        },
        init() {
            this.changeCalendar(new Date());
            this.legends.forEach((legend) => {
                this.legendColors.push(legend.color);
                if (legend.split_color != null) {
                    this.legendColors.push(legend.split_color);
                }
                if (legend.gradient != null) {
                    this.legendColors.push(...legend.gradient.split(" "));
                }
            });
            this.quickEdit.legend = this?.legends[0]?.id ?? -1;

            this.$watch("currMonthYear", (newValue) => {
                this.changeCalendar(this.getDate(newValue));
            });
            this.$watch("calendar", () => {
                const date = this.getDate();
                const month = (date.getMonth() + 1).toString().padStart(2, "0");
                const year = date.getFullYear();
                this.quickEdit.from = `${year}-${month}-01`;
                this.quickEdit.minDate = this.quickEdit.from;
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

        changeLegendColor(el, date) {
            const legend = this.legends.find((legend) => legend.id == el.value);
            const color = legend.color;
            const gradient = legend.gradient;

            this.changeDateColor(date, color, gradient);
        },

        changeLegend(date) {
            const legendId = document.getElementById(`legend-${date}`).value;
            const currentLegendIndex = this.legends.findIndex(
                (legend) => legend.id == legendId
            );
            const newLegendIndex =
                (currentLegendIndex + 1) % this.legends.length;
            const newLegend = this.legends[newLegendIndex];
            const newColor = newLegend.color;
            const newSplitColor = newLegend.split_color;

            this.changeDateColor(date, newColor, newSplitColor);
            document.getElementById(`legend-${date}`).value = this.legends[newLegendIndex].id;
        },

        changeDateColor(date, color, splitColor = null) {
            if (date == null || color == null) return;
            const Date_COLOR_DIV = document.getElementById(`date-color-${date}`);
            const Calendar_Date_COLOR_DIV = document.getElementById(`calendar-date-color-${date}`);
            const CALENDAR_DATE = document.getElementById(`date-${date}`);
            const gradientColors = splitColor ? splitColor.split(" ") : [];

            CALENDAR_DATE.classList.remove(...this.legendColors);

            if (splitColor != null) {
                const div1 = `<div class="absolute w-full h-full overflow-hidden clip-left" style="background-color: ${color}"></div>`;
                const div2 = `<div class="absolute w-full h-full overflow-hidden clip-right" style="background-color: ${splitColor}"></div>`;
                const div = div1 + div2;
                Date_COLOR_DIV.innerHTML = div;
                Calendar_Date_COLOR_DIV.innerHTML = div;
            } else {
                const div = ` <div class="absolute w-full h-full overflow-hidden" style="background-color: ${color}"></div>`;
                Date_COLOR_DIV.innerHTML = div;
                Calendar_Date_COLOR_DIV.innerHTML = div;
            }
        },

        getCalendar() {
            if (
                this.calendarId == null ||
                this.organizationId == null ||
                this.currMonthYear == null
            ) {
                return;
            }
            this.isCalendarLoading = true;
            const BASE_URI = `/api/calendars/${this.calendarId}`;
            const MONTH_YEAR = `?month_year=${this.currMonthYear}`;
            const ORGANIZATION_ID = `&organization_id=${this.organizationId}`;
            const URI = BASE_URI + MONTH_YEAR + ORGANIZATION_ID;

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

        quickEditCalendar() {
            if (
                this.calendarId == null ||
                this.organizationId == null ||
                this.quickEdit.from == null ||
                this.quickEdit.to == null ||
                this.quickEdit.legend == null ||
                window.userId == null
            ) {
                return;
            }
            this.isQuickEditLoading = true;
            const URI = `/api/calendars/${this.calendarId}/quick-update`;

            axios.post(URI, {
                    from: this.quickEdit.from,
                    to: this.quickEdit.to,
                    legend_id: this.quickEdit.legend,
                    remarks: this.quickEdit.remarks,
                    user_id: window.userId,
                }).then(() => {
                    this.changeCalendar(new Date());
                }).finally(() => {
                    this.isQuickEditLoading = false;
                });
        }
    }));
});
