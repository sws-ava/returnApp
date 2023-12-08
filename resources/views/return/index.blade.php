<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Return</title>
    <link href="/css/style.css" rel="stylesheet">
    <link href="/css/print.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <!-- <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet"> -->
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
</head>
<body>
    <div id="content" class="wrapper">
        <div id="page" class="page">
            <div id="wrapper" class="case">
                <div class="return-page">
                    <form class="return-page__form" action="{{ route('return.return_pdf') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="return-page__head">
                            <div class="barcode">
                                <div class="return-page__logo">
                                    <img src="/images/logo.png" alt="">
                                </div>
                                <!-- <svg id="barcode"></svg> -->
                            </div>
                            <div class="return-page__person">
                                <div class="auth__field field --sm --b-gray --required">
                                    <div class="field__title --gray">От кого (ФИО)</div>
                                    <div class="field__wrap">
                                        <input autocomplete="off" class="field__area" type="text" name="name" required="required">
                                    </div>
                                    <div class="field__error"></div>
                                </div>
    
                                <div class="auth__field field --sm --b-gray --required">
                                    <div class="field__title --gray">E-mail</div>
                                    <div class="field__wrap">
                                        <input autocomplete="off" class="field__area" type="email" name="email" required="required">
                                    </div>
                                    <div class="field__error"></div>
                                </div>
    
                                <div class="auth__field field --sm --b-gray --required">
                                    <div class="field__title --gray">Телефон</div>
                                    <div class="field__wrap">
                                        <input autocomplete="off" class="field__area" type="text" id="phone" name="phone"  inputmode="numeric" required="required">
                                    </div>
                                    <div class="field__error"></div>
                                </div>
                            </div>
                        </div>
                        <input value="" name="return_barcode" class="barcodeInput" id="barcodeInput" type="hidden">

                        <div class="items">
                            <div class="items__title">
                                Заявление на возврат
                            </div>
                            <div class="items__base">
                                <div class="items__order-number">
                                    <div class="auth__field field --sm --b-gray --required">
                                        <div class="field__title --gray">Номер заказа</div>
                                        <div class="field__wrap">
                                            <input autocomplete="off" class="field__area" type="text" name="order_number"  required="required">
                                        </div>
                                        <div class="field__error"></div>
                                    </div>
                                </div>
                                <div class="items__order-date">
                                    <div class="auth__field field --sm --b-gray --required">
                                        <div class="field__title --gray">Дата доставки заказа</div>
                                        <div class="field__wrap">
                                            <input 
                                                autocomplete="off" 
                                                id="dateInput" 
                                                class="field__area date" 
                                                type="text" 
                                                name="order_date" 
                                                required="required"
                                            >
                                        </div>
                                        <div class="field__error"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="rows__holder">
                                <div id="list-rows" class="rows">
                                    <div class="row --header" data-row-id="0">
                                        <div class="row__cell">№</div>
                                        <div class="row__cell">Артикул</div>
                                        <div class="row__cell">Наименование</div>
                                        <div class="row__cell">Раз-<br>мер</div>
                                        <div class="row__cell">Коли-<br>чество</div>
                                        <div class="row__cell">Стоимость</div>
                                        <div class="row__cell">Причина <br> возврата</div>
                                    </div>
                                    <div class="row list-row itemRow"  data-row-id="1">
                                        <div class="row__cell --text-center list-row-num">
                                            1
                                        </div>
                                        <div class="row__cell">
                                            <input
                                                required
                                                name="rows[1][article]"
                                                type="text"
                                                autocomplete="off"
                                                placeholder="Артикул товара"
                                            >
                                        </div>
                                        <div class="row__cell --item-name">
                                            <input
                                                required
                                                name="rows[1][name]"
                                                type="text"
                                                autocomplete="off"
                                                placeholder="Название товара"
                                            >
                                        </div>
                                        <div class="row__cell --text-center">
                                            <input
                                                required
                                                name="rows[1][size]"
                                                type="text"
                                                autocomplete="off"
                                                placeholder="Размер"
                                            >
                                        </div>
                                        <div class="row__cell --text-center">
                                            <input
                                                class="itemCount"
                                                required
                                                name="rows[1][count]"
                                                type="number"
                                                autocomplete="off"
                                                oninput="calcSum()"
                                                placeholder="Количество"
                                            >
                                        </div>
                                        <div class="row__cell --text-center">
                                            <input
                                                placeholder="Цена"
                                                class="itemSum"
                                                required
                                                name="rows[1][price]"
                                                type="number"
                                                autocomplete="off"
                                                oninput="calcSum()"
                                            >
                                        </div>
                                        <div class="row__cell --item-name">
                                            <select
                                                id="reasonSelectBlock"
                                                name="rows[1][reason]"
                                                required
                                            >
                                                <option value="" >Причина возврата</option>
                                                @foreach($returnReasonsList as $item)
                                                    <option value="{{$item->id}}"> {{$item->attributes->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div onClick="addRow()" class="row__plus button --sm --bg-primary">
                                Добавить строку
                            </div>
                            <div class="info --mt-10 sum">
                                На основании вышеизложенного, в соответствии с Законом РФ «О защите прав потребителей» № 2300-1
                                от 07.02.92 г., прошу расторгнуть со мной договор купли-продажи и возвратить сумму в размере:
                                <div class="field__wrap --inline-block ">
                                    <div class="auth__field field --sm --b-gray --required">
                                        <input disabled class="totalBlock field__area" type="text" name="sum" required />
                                    </div>
                                </div>руб
                            </div>
                            <label onclick="hideSubForm()" class="auth__checkbox checkbox --sm --b-gray">
                                <input name="pay-type" value="1" class="checkbox__input" type="radio" checked>
                                <div class="checkbox__wrap">
                                    <div class="checkbox__icon-wrap">
                                        <svg class="checkbox__icon icon icon-check" viewBox="0 0 256 256" xmlns="http://www.w3.org/2000/svg">
                                            <use xlink:href="/images/sprite.svg#icon-check"></use>
                                        </svg>
                                    </div>
                                    <div class="checkbox__text">
                                        <div class="checkbox__title --gray ttu">Оплачивала картой на сайте. Прошу перечислить денежные средства на карту, с которой они были списаны.</div>
                                    </div>
                                </div>
                            </label>
                            <label onclick="showSubForm()" class="auth__checkbox checkbox --sm --b-gray">
                                <input name="pay-type" value="2" class="checkbox__input" type="radio">
                                <div class="checkbox__wrap">
                                    <div class="checkbox__icon-wrap">
                                        <svg class="checkbox__icon icon icon-check" viewBox="0 0 256 256" xmlns="http://www.w3.org/2000/svg">
                                            <use xlink:href="/images/sprite.svg#icon-check"></use>
                                        </svg>
                                    </div>
                                    <div class="checkbox__text">
                                        <div class="checkbox__title --gray ttu">Оплачивала курьеру при получении. Прошу перечислить денежные средства по реквизитам:</div>
                                    </div>
                                </div>
                            </label>
    
                            <div id="return-page__person" class="return-page__person d-none" style="margin-top: 50px;">
                                <div class="auth__field field --sm --b-gray --required">
                                    <div class="field__title --gray">ФИО</div>
                                    <div class="field__wrap">
                                        <input id="fio" class="field__area" type="text" name="fio">
                                    </div>
                                    <div class="field__error"></div>
                                </div>
    
                                <div class="auth__field field --sm --b-gray --required">
                                    <div class="field__title --gray">БИК</div>
                                    <div class="field__wrap">
                                        <input id="bik" class="field__area" type="text" name="bik">
                                    </div>
                                    <div class="field__error"></div>
                                </div>
    
                                <div class="auth__field field --sm --b-gray --required">
                                    <div class="field__title --gray">Номер счета получателя</div>
                                    <div class="field__wrap">
                                        <input id="bank" class="field__area" type="text" name="bank">
                                    </div>
                                    <div class="field__error"></div>
                                </div>

                                
                            </div>
                            <div class="return-page__bottom-block">
                                <div class="auth__field field --sm --b-gray">
                                    <div class="d-flex field__title --gray">Дата <span class="underline" id="dateNow"></span></div>
                                </div>
                                <div class="auth__field field --sm --b-gray sign__block">
                                    <div class="d-flex field__title --gray">Подпись <span class="underline sign"></span></div>
                                </div>
                            </div>
                        </div>
                        <p class="info noprint">
                            Вы можете оформить возврат товара в течение 7 дней с момента получения заказа при условии сохранения его
                            товарного вида (ФЗ «О защите прав потребителей» ст. 26 1. п.4). Для этого заполните ниже представленную форму
                            возврата и вложите бланк в посылку с товарами, которые хотите вернуть.
                        </p>

                        <div class="agree-block">
                            <label class="auth__checkbox checkbox --sm --b-gray">
                                <input name="" class="checkbox__input" type="checkbox" required>
                                <div class="checkbox__wrap">
                                    <div class="checkbox__icon-wrap">
                                        <svg class="checkbox__icon icon icon-check" viewBox="0 0 256 256" xmlns="http://www.w3.org/2000/svg">
                                            <use xlink:href="/images/sprite.svg#icon-check"></use>
                                        </svg>
                                    </div>
                                    <div class="checkbox__text">
                                        <div class="checkbox__title --gray ttu">Согласие на <a href="https://selfmade.ru/page/agreement" target="_blank">обработку персональных данных</a></div>
                                    </div>
                                </div>
                            </label>
                            <label class="auth__checkbox checkbox --sm --b-gray">
                                <input name="" class="checkbox__input" type="checkbox" required>
                                <div class="checkbox__wrap">
                                    <div class="checkbox__icon-wrap">
                                        <svg class="checkbox__icon icon icon-check" viewBox="0 0 256 256" xmlns="http://www.w3.org/2000/svg">
                                            <use xlink:href="/images/sprite.svg#icon-check"></use>
                                        </svg>
                                    </div>
                                    <div class="checkbox__text">
                                        <div class="checkbox__title --gray ttu">Согласие на <a href="https://selfmade.ru/page/return" target="_blank">условия возврата</a></div>
                                    </div>
                                </div>
                            </label>
                        </div>
                        <div class="submit-holder">
                            
                            <button onclick="submitForm()"  name="submitButton"  type="submit" class="noprint return-page__submit button --sm --bg-primary">
                                Отправить
                            </button>
                            <!-- <a class ="print-doc noprint" href="javascript:(print());">
                                <img class="print-doc__img" src="/images/print.png" alt="">
                            </a> -->
                        </div>
                    </form>

                    <div class="self-return">
                        <p class="self-return__desc">
                            Возврат товара возможен в течение 7 календарных дней с даты получения заказа.
                            <br>
                            Возврат товара возможен, если сохранен документ, подтверждающий покупку (чек) и товарный вид: сохранены этикетка, ярлык, потребительские свойства
                        </p>
                        <div class="self-return__title">Самостоятельный возврат
                        </div>
                        <div class="self-return__sub-title">Если доставка была службой СДЭК:</div>
                        <ul>
                            <li>1. Заполните форму возврата, которая была вложена в вашу посылку.ВАЖНО! Возвраты без заявления
                                не будут приняты и мы не сможем осуществить возврат денежных средств.
                            </li>
                            <li>
                                2. Обратитесь на горячую линию и в пункт выдачи СДЭК с трек-номером вашего заказа, указанным на упаковке, и сообщите, что вам необходимо оформить «Клиентский возврат» на ООО «Инстита».
                            </li>
                            <li>
                                3. Проверьте наличие бирок и ярлыков, герметично упакуйте посылку и отправьте ее через удобный для вас пункт СДЭК
                            </li>
                            <li>
                                4. После отправки напишите нам на почту online@selfmade.ru номер заказа, фамилию и имя, товар,
                                который хотите вернуть и причину возврата. В теме письма укажите «возврат»
                            </li>
                        </ul>
                        <br><br>
                        <div class="self-return__sub-title">Если доставка была курьером с примеркой по Москве или Санкт-Петербургу:</div>
                        <ul>
                            <li>
                                1. Заполните форму возврата, каторая была вложена в вашу посылку, или обратитесь в нашу поддержку, чтобы менеджер прислал вам заявление. ВАЖНО! Возвраты без заявления не будут приняты и мы не сможем осуществить возврат денежных средств.
                            </li>
                            <li>
                                2. Обратитесь в нашу службу поддержки, наши менеджеры согласуют с вами удобный способ возврата:
                                курьером или через пункт выдачи СДЭК.
                            </li>
                            <li>
                                3. В зависимости от выбранного варианта менеджер согласует с вами дату приезда курьера за
                                посылкой или пришлет транспортную накладную для отправки через пункт СДЭК.
                            </li>
                            <li>
                                4. Проверьте наличие бирок и ярлыков, герметично упакуйте посылку и отправьте ее через удобный для вас пункт СДЭК
                            </li>
                            <li>
                                5. После отправки напишите нам на почту online@selfmade.ru номер заказа, фамилию и имя, товар,
                                который хотите вернуть и причину возврата. В теме письма укажите «возврат». Денежные средства
                                будут отправлены на ваш счет в течение 10 рабочих дней после того, как возврат поступит на наш
                                склад.
                            </li>
                        </ul>
                        <p>
                            Если вам необходим обмен товара, обратитесь в нашу службу поддержки на сайте и менеджер проконсультирует и поможет его оформить.
                        </p>
                    </div>

<!-- 
                    <div class="success-modal">
                        <div class="success-modal__bg"></div>
                        <div class="success-modal__wrapper">
                            <div class="success-modal__inner">
                                <div class="success-modal__title">
                                    Заявка принята!
                                    <span onclick="hideSuccessModal()">X</span>
                                </div>
                                <div class="success-modal__text">Спасибо, ваша заявка принята!</div>
                                <div  onclick="hideSuccessModal()" class="success-modal__button  button --sm --bg-primary">Спасибо</div>
                            </div>
                        </div>
                    </div> -->
                </div>
            </div>
            <!-- <div id="editor"></div> -->

            <!-- <div class="show-success-modal" style="margin-top: 50px;" onclick="showSuccessModal()">Модалка</div> -->
        </div>
        <script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.6/dist/barcodes/JsBarcode.code128.min.js"></script>
        
        <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
        <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.8/jquery.inputmask.min.js"></script>
        <script src='/js/index.js'></script>
        <script src='/js/checkbox.js'></script>
        <script src='/js/validation.js'></script>
        <script type="text/javascript" src="/js/i18n/datepicker-ru.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.4.1/jspdf.min.js"></script>
        <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js" integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> -->
        <script>
            $( function() {
              $( "#dateInput" ).datepicker(
                { dateFormat: 'dd.mm.yy', language: "ru" }
                );
            } );
            $(document).ready(function () {
                $("#phone").inputmask({"mask": "+7 (999) 999-99-99"});
            });
        </script>
    </div>
</body>
</html>