function addRow(){
    let rows = document.querySelectorAll('.list-row')
    let lastRow = rows[rows.length-1]
    if(lastRow){
        let lastRowId = lastRow.dataset.rowId
        let newRowSelectBlock = setNewRowSelectBlock(lastRowId * 1 + 1)
        let newRow = newRowTemplateHandler(lastRowId * 1 + 1, newRowSelectBlock)
        let rowsList = document.getElementById('list-rows')
        rowsList.insertAdjacentHTML('beforeEnd', newRow)
    }
    renumRows()
}

function removeRow(id){
    let rowToRemove = document.querySelector(`[data-row-id="${id}"]`)
    let list = document.getElementById("list-rows");
    if(rowToRemove && list){
        list.removeChild(rowToRemove);
    }
    renumRows()
    calcSum()
}

function renumRows(){
    let rows = document.querySelectorAll('.list-row')
    rows.forEach((el, i) => {
        let listRowNum = el.querySelector('.list-row-num')
        if(listRowNum){
            listRowNum.innerText = i+1
        }
    })
}

function setNewRowSelectBlock(id){
    let reasonSelectBlock = document.getElementById('reasonSelectBlock')
    let select = document.createElement("select")
    select = reasonSelectBlock.cloneNode(true);
    select.name = 'rows['+ id + '][reason]'
    return select.outerHTML
}

function newRowTemplateHandler(id, newRowSelectBlock){
    return `
        <div class="row list-row itemRow"  data-row-id="${id}">
            <div class="row__cell --text-center list-row-num">

            </div>
            <div class="row__cell">
                <input
                    required
                    name="rows[${id}][article]"
                    type="text"
                    autocomplete="off"
                    placeholder="Артикул товара"
                >
            </div>
            <div class="row__cell --item-name">
                <input
                    required
                    name="rows[${id}][name]"
                    type="text"
                    autocomplete="off"
                    placeholder="Название товара"
                >
            </div>
            <div class="row__cell --text-center">
                <input
                    required
                    name="rows[${id}][size]"
                    type="text"
                    autocomplete="off"
                    placeholder="Размер"
                >
            </div>
            <div class="row__cell --text-center">
                <input
                    class="itemCount"
                    required
                    name="rows[${id}][count]"
                    type="number"
                    oninput="calcSum()"
                    autocomplete="off"
                    placeholder="Количество"
                >
            </div>
            <div class="row__cell --text-center">
                <input
                    placeholder="Цена"
                    class="itemSum"
                    required
                    name="rows[${id}][price]"
                    type="text"
                    autocomplete="off"
                    oninput="calcSum()"
                >
            </div>
            <div class="row__cell --item-name">
                ${newRowSelectBlock}
            </div>
            <div onclick="removeRow(${id})" class="row__minus button --sm --bg-primary row__remove-row-btn">-</div>
        </div>
    `
}


let dateBlock = document.getElementById('dateNow')
let currentDate = new Date();
let currentDateOut = currentDate.getDate() +'.' + (currentDate.getMonth() * 1 + 1) +  '.' + currentDate.getFullYear()
dateBlock.innerText = currentDateOut

// function reBarcode(){
//     let dateNow = Date.now()
// JsBarcode("#barcode", dateNow, {
//     height: 80,
//   });
// }

let dateNow = Date.now()
// JsBarcode("#barcode", dateNow, {
//     height: 80,
//   });
let barcodeInput = document.getElementById('barcodeInput')
barcodeInput.value = dateNow

function hideSubForm(){
    let subForm = document.getElementById('return-page__person')
    document.getElementById('fio').required = false
    document.getElementById('bik').required = false
    document.getElementById('bank').required = false


    subForm.classList.add('d-none') 
}
function showSubForm(){
    let subForm = document.getElementById('return-page__person')
    document.getElementById('fio').required = true
    document.getElementById('bik').required = true
    document.getElementById('bank').required = true
    subForm.classList.remove('d-none') 
}



// paragraph.replace("Ruth's", 'my')
function calcSum(){
    let items = document.querySelectorAll('.itemRow')
    let total = 0
    if(items && items.length > 0){
        items.forEach((item) => {
            let itemCount = item.querySelector('.itemCount').value;
            let itemSum = item.querySelector('.itemSum').value;
            itemSum.value = itemSum.replace(',', '.')
            console.log(itemSum.replace(',', '.'));
            total += Number(itemCount * itemSum.replace(',', '.'))
        })
    }
    let totalBlock = document.querySelector('.totalBlock')
    totalBlock.value = total > 0 ? total : ''
}

function hideSuccessModal(){
    let modal = document.querySelector('.success-modal')
    modal.classList.remove('--show')
}

function showSuccessModal(){
    let modal = document.querySelector('.success-modal')
    modal.classList.add('--show')
}


function submitForm(){
    $("#returnRequestForm").submit(function () {
        window.open('https://selfmade.ru/', '_blank');
        return
    });
}
