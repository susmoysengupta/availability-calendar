 @props(['disabled' => false, 'defaultColor' => '', 'id' => ''])
 <div x-data="colorPicker()" x-init="[init()]">
     <div class="relative flex w-full" :id="$id('text-input')">
         <!-- color picker input -->
         <div class="flex w-full">
             <input id="code-{{ $id }}" x-ref="currentColorCodeRef" {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'text-sm border-gray-300 border-r-0 rounded-md rounded-r-none shadow-sm required dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input color-input']) !!}>
             <button type="button" x-show="showClearButton" @click="clear()" class="px-3 py-2 border-t border-b border-gray-300 dark:bg-gray-700 dark:border-gray-600">
                 <i class="text-gray-500 cursor-pointer hover:text-gray-700 dark:hover:text-gray-200 fa-solid fa-xmark"></i>
             </button>
         </div>
         <!-- color show div -->
         <label class="flex items-center justify-center px-3 text-gray-700 border border-gray-300 cursor-pointer dark:text-gray-400 dark:border-gray-600 rounded-r-md">
             <input id="color-{{ $id }}" x-model="currentColor" value="{{ $defaultColor }}" type="color" @change="changeColor()">
         </label>
     </div>
 </div>

 @push('custom-scripts')
     <script>
         function colorPicker() {
             return {
                 defaultColor: '#ffffff',
                 currentColor: "",
                 showClearButton: false,

                 init: function() {
                     if (this.$refs.currentColorCodeRef.value) {
                         this.currentColor = this.$refs.currentColorCodeRef.value;
                         this.showClearButton = true;
                     } else {
                         this.currentColor = this.defaultColor;
                         this.showClearButton = false;
                     }
                 },

                 changeColor: function() {
                     this.$refs.currentColorCodeRef.value = this.currentColor;
                     this.showClearButton = true;
                 },

                 clear: function() {
                     this.currentColor = this.defaultColor;
                     this.$refs.currentColorCodeRef.value = "";
                     this.showClearButton = false;
                 }
             };
         }
     </script>
 @endpush
