function dropdown() {
  return {
    options: [],
    selected: [],
    show: false,
    open() {
      this.show = true;
    },
    close() {
      this.show = false;
    },
    isOpen() {
      return this.show === true;
    },
    select(index, event) {
      if (!this.options[index].selected) {
        this.options[index].selected = true;
        this.options[index].element = event.target;
        this.selected.push(index);
      } else {
        this.selected.splice(this.selected.lastIndexOf(index), 1);
        this.options[index].selected = false;
      }
    },
    remove(index, option) {
      this.options[option].selected = false;
      this.selected.splice(index, 1);
    },
    loadOptions() {
      const options = document.getElementById("select").options;
      for (let i = 0; i < options.length; i++) {
        this.options.push({
          value: options[i].value,
          text: options[i].innerText,
          selected: options[i].getAttribute("selected") != null ? options[i].getAttribute("selected") : false,
        });
      }
    },
    selectedValues() {
      return this.selected.map((option) => {
        return this.options[option].value;
      });
    },
  };
}

// //////////////////////////////////////////////////////////
// //////////////////////////////////////////////////////////
// //////////////////////////////////////////////////////////
// FLORAL EDITOR FOR TEXTAREA
// //////////////////////////////////////////////////////////
// //////////////////////////////////////////////////////////
// //////////////////////////////////////////////////////////

// //////////////////////////////////////////////////////////
// //////////////////////////////////////////////////////////
// //////////////////////////////////////////////////////////
// CUSTOM JS
// //////////////////////////////////////////////////////////
// //////////////////////////////////////////////////////////
// //////////////////////////////////////////////////////////

// **********************************************************
// **********************************************************
// CALENDAR TABLE OPTIONS DROPDOWN
// **********************************************************
// **********************************************************

const calendarTableDropdownBtn = document.querySelectorAll(".calendar-table-dropdown-btn");
const calendarTableDropdown = document.querySelectorAll(".calendar-table-dropdown");

for (let i = 0; i < calendarTableDropdownBtn.length; i++) {
  calendarTableDropdownBtn[i].addEventListener("click", function () {
    calendarTableDropdown[i].classList.toggle("hidden");
  });
  calendarTableDropdownBtn[i].addEventListener("focusout", function () {
    const myTimeout = setTimeout(function () {
      calendarTableDropdown[i].classList.add("hidden");
    }, 150);
  });
}

// **********************************************************
// **********************************************************
// EXPAND BOTTOM DIV
// **********************************************************
// **********************************************************

const expandBottomBtn = document.querySelectorAll(".expand-bottom-btn");
const expandBottomDiv = document.querySelectorAll(".expand-bottom-div");
const dropArrowDown = document.querySelectorAll(".drop-arrow-down");
const dropArrowUp = document.querySelectorAll(".drop-arrow-up");

for (let i = 0; i < expandBottomBtn.length; i++) {
  expandBottomBtn[i].addEventListener("click", function () {
    expandBottomDiv[i].classList.toggle("hidden");
    dropArrowDown[i].classList.toggle("hidden");
    dropArrowUp[i].classList.toggle("hidden");
  });
}

// **********************************************************
// **********************************************************
// INPUT FIELD COLOR
// **********************************************************
// **********************************************************

// const mainColorInput = document.querySelectorAll(".main-color-input");
// const colorPickerColor = document.querySelectorAll(".color-picker-color");

// for (let i = 0; i < colorPickerColor.length; i++) {
//   colorPickerColor[i].addEventListener("click", function () {
//     mainColorInput[i].focus();
//   });
// }

// const splitColorCheckbox = document.getElementById("split_color");
// const splitColorInput = document.querySelector(".split-color-input");

// if ((splitColorCheckbox.checked = true)) {
//   splitColorInput.classList.remove("hidden");
// } else {
//   splitColorInput.classList.add("hidden");
// }

// **********************************************************
// **********************************************************
// CALENDAR
// **********************************************************
// **********************************************************
