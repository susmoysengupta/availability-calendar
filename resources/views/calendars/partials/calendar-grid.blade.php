<section class="row-start-1 p-4 text-gray-700 bg-white rounded-md shadow-sm dark:bg-gray-800 dark:text-gray-200 xl:flex xl:justify-center lg:col-start-2">
    <div class="px-4 py-8 mx-auto bg-white border border-gray-200 rounded-md shadow-md dark:bg-gray-800 dark:border-gray-600">
        <!-- CALENDAR SECTION STARTS -->
        <div class="overflow-hidden text-xs text-gray-800 bg-white border border-gray-200 rounded-md shadow-md calendar-container dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200">
            <header class="flex items-center justify-between gap-4 p-3 font-bold text-center month">
                <button id="prev" @click="showPreviousMonth()">
                    <i class="cursor-pointer fa-solid fa-chevron-left"></i>
                </button>
                <x-select-input x-model="currentMonthYear" @change="changeCurrentMonth()" name="current_month" class="w-1/2 text-xs text-gray-600 ">
                    <template x-for="month in months" :key="month.value">
                        <option x-text="month.label" :value="month.value"></option>
                    </template>
                </x-select-input>
                <button id="next" @click="showNextMonth()">
                    <i class="cursor-pointer fa-solid fa-chevron-right"></i>
                </button>
            </header>


            <hr class="border-gray-200 dark:border-gray-600" />

            <!-- WEEKDAYS SECTION -->
            <div class="grid w-full h-10 grid-cols-7 font-semibold uppercase">
                <template x-for="week in weeks">
                    <div x-text="week" class="flex items-center justify-center w-12 h-full border-r border-gray-200 dark:border-gray-600"></div>
                </template>
            </div>

            <hr class="border-gray-200 dark:border-gray-600" />

            <!-- DAYS SECTION -->
            <div class="flex flex-wrap w-full h-10 font-semibold">
                <div class="flex items-center justify-center w-12 h-full border-b border-r border-gray-200 dark:border-gray-600 calendar-available">1</div>
                <div class="flex items-center justify-center w-12 h-full border-b border-r border-gray-200 dark:border-gray-600 calendar-available">1</div>
                <div class="flex items-center justify-center w-12 h-full border-b border-r border-gray-200 dark:border-gray-600 calendar-available">1</div>
                <div class="flex items-center justify-center w-12 h-full border-b border-r border-gray-200 dark:border-gray-600 calendar-available">1</div>
                <div class="flex items-center justify-center w-12 h-full border-b border-r border-gray-200 dark:border-gray-600 calendar-available">1</div>
                <div class="flex items-center justify-center w-12 h-full border-b border-r border-gray-200 dark:border-gray-600 calendar-available">1</div>
                <div class="flex items-center justify-center w-12 h-full border-b border-r border-gray-200 dark:border-gray-600 calendar-available">1</div>
                <div class="flex items-center justify-center w-12 h-full border-b border-r border-gray-200 dark:border-gray-600 calendar-available">1</div>
                <div class="flex items-center justify-center w-12 h-full border-b border-r border-gray-200 dark:border-gray-600 calendar-available">1</div>

                {{-- <template x-for="day in daysInCurrentMonth" x-key="day.index">
                    <div class="flex items-center justify-center p-0 border-b border-r border-gray-200 dark:border-gray-600">
                        <p class="flex items-center justify-center w-full h-full text-gray-800 bg-green-200" x-text="day.label"></p>
                        <template x-if="day.index == -1">
                            <p class="bg-gray-100cursor-not-allowe dark:bg-gray-800"></p>
                        </template>

                        <template x-if="day.index != -1">
                        </template>
                    </div>
                </template> --}}
                {{-- <template x-for="day in daysInCurrentMonth" x-key="day.value">
                    <div class="border-r border-gray-200 dark:border-gray-600 calendar-available" x-text="day.value"></div>
                </template> --}}
                {{-- <div class="border-r border-gray-200 dark:border-gray-600 calendar-available" x-text="day"></div>
                    <div class="text-gray-400 bg-gray-100 border-b border-r border-gray-200 cursor-none prev-days dark:border-gray-600 dark:bg-gray-800"></div>
                    <div class="text-gray-400 bg-gray-100 border-b border-r border-gray-200 cursor-not-allowed prev-days dark:border-gray-600 dark:bg-gray-800"></div>
                    <div class="text-gray-400 bg-gray-100 border-b border-r border-gray-200 cursor-not-allowed prev-days dark:border-gray-600 dark:bg-gray-800"></div>
                    <div class="border-b border-r border-gray-200 dark:border-gray-600 calendar-available">1</div>
                    <div class="border-b border-r border-gray-200 dark:border-gray-600 calendar-available">2</div>
                    <div class="border-b border-r border-gray-200 dark:border-gray-600 calendar-available">3</div>
                    <div class="border-b border-gray-200 dark:border-gray-600 calendar-available">4</div>
                    <div class="border-b border-r border-gray-200 dark:border-gray-600 calendar-available">5</div>
                    <div class="border-b border-r border-gray-200 dark:border-gray-600 calendar-available">6</div>
                    <div class="border-b border-r border-gray-200 dark:border-gray-600 calendar-available">7</div>
                    <div class="border-b border-r border-gray-200 dark:border-gray-600 calendar-booked">8</div>
                    <div class="border-b border-r border-gray-200 dark:border-gray-600 calendar-booked">9</div>
                    <div class="border-b border-r border-gray-200 dark:border-gray-600 calendar-booked today">10</div>
                    <div class="border-b border-gray-200 dark:border-gray-600 calendar-available">11</div>
                    <div class="border-b border-r border-gray-200 dark:border-gray-600 calendar-booked">12</div>
                    <div class="border-b border-r border-gray-200 dark:border-gray-600 calendar-booked">13</div>
                    <div class="border-b border-r border-gray-200 dark:border-gray-600 calendar-booked">14</div>
                    <div class="border-b border-r border-gray-200 dark:border-gray-600 calendar-booked">15</div>
                    <div class="border-b border-r border-gray-200 dark:border-gray-600 calendar-booked">16</div>
                    <div class="border-b border-r border-gray-200 dark:border-gray-600 calendar-booked">17</div>
                    <div class="border-b border-gray-200 dark:border-gray-600 calendar-booked">18</div>
                    <div class="border-b border-r border-gray-200 dark:border-gray-600 calendar-available">19</div>
                    <div class="border-b border-r border-gray-200 dark:border-gray-600 calendar-available">20</div>
                    <div class="border-b border-r border-gray-200 dark:border-gray-600 calendar-available">21</div>
                    <div class="border-b border-r border-gray-200 dark:border-gray-600 calendar-available">22</div>
                    <div class="border-b border-r border-gray-200 dark:border-gray-600 calendar-available">23</div>
                    <div class="border-b border-r border-gray-200 dark:border-gray-600 calendar-available">24</div>
                    <div class="border-b border-gray-200 dark:border-gray-600 calendar-available">25</div>
                    <div class="border-b border-r border-gray-200 dark:border-gray-600 calendar-changeover">26</div>
                    <div class="border-b border-r border-gray-200 dark:border-gray-600 calendar-changeover">27</div>
                    <div class="border-b border-r border-gray-200 dark:border-gray-600 calendar-changeover">28</div>
                    <div class="border-b border-r border-gray-200 dark:border-gray-600 calendar-booked">29</div>
                    <div class="border-b border-r border-gray-200 dark:border-gray-600 calendar-booked">30</div>
                    <div class="border-b border-r border-gray-200 dark:border-gray-600 calendar-booked">31</div>
                    <div class="text-gray-400 bg-gray-100 border-b border-r border-gray-200 cursor-none prev-days dark:border-gray-600 dark:bg-gray-800"></div> --}}

            </div>
        </div>

        <hr class="mt-5 mb-5 border-gray-200 dark:border-gray-600" />

        <div class="flex flex-col gap-3">
            <div class="flex justify-between">
                <h3 class="text-sm font-bold">Legends</h3>
                <a href="./add-legend.html" class="text-sm font-semibold text-purple-600">Edit</a>
            </div>
            <div class="flex flex-col gap-2">
                <div class="flex items-center gap-2">
                    <span class="inline-block w-3 h-3 calendar-available"></span>
                    <span class="text-xs font-semibold">Available</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="inline-block w-3 h-3 calendar-booked"></span>
                    <span class="text-xs font-semibold">Booked</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="inline-block w-3 h-3 calendar-changeover"></span>
                    <span class="text-xs font-semibold">Changeover</span>
                </div>
            </div>
        </div>
    </div>
</section>
