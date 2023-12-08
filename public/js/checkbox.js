// class Checkbox {
//     static classChecked = '--checked';
//     static selectorCheckbox = '.checkbox';
//     static selectorInput = '.checkbox__input';
//     input = null;
//     isChecked = false;
//     constructor(element) {
//         this.element = element;
//         this.element._input = this.input = element.querySelector(Checkbox.selectorInput);

//         if (this.input.checked) {
//             this.isChecked = true;

//             this.toggleChecked();
//         }

//         this.element.addEventListener('click', ()=>{
//             this.isChecked = !this.isChecked;
//             this.input.checked = this.isChecked;

//             this.toggleChecked();

//             this.input.dispatchEvent(new Event('change'))
//         });
//     }

//     static init() {
//         const checkboxes = document.querySelectorAll(Checkbox.selectorCheckbox);

//         checkboxes?.forEach((checkbox)=>{
//            new Checkbox(checkbox);
//         });
//     }

//     toggleChecked() {
//         if (this.isChecked) {
//             this.setChecked();
//         } else {
//             this.setUnchecked();
//         }
//     }

//     setChecked() {
//         // this.element.classList.add(Checkbox.classChecked);
//     }

//     setUnchecked() {
//         // this.element.classList.remove(Checkbox.classChecked);
//     }
// }

// export default Checkbox;
