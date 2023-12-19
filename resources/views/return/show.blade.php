<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Возврат товара</title>
    <link rel="icon" type="image/svg+xml" href="/images/favicon.png" />
    <link href="/css/style.css" rel="stylesheet">
    <link href="/css/print.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
</head>
<body>
    <div id="content" class="wrapper">
        <div id="page" class="page">
            <div id="wrapper" class="case">
                <div class="return-page">
                    <div class="return-page__form">
                        @csrf
                        <div class="return-page__head">
                            <div class="barcode">
                                <div class="return-page__logo">
                                    <img src="/images/logo.png" alt="">
                                </div>
                            </div>
                            <div class="return-page__person">
                                <div class="auth__field field --sm --b-gray --required">
                                    <div class="field__title --gray">От кого (ФИО)</div>
                                    <div class="field__wrap">
                                        <input value="{{ $item->attributes->client_fio }}" readonly autocomplete="off" class="field__area" type="text" name="name" required="required">
                                    </div>
                                    <div class="field__error"></div>
                                </div>
    
                                <div class="auth__field field --sm --b-gray --required">
                                    <div class="field__title --gray">E-mail</div>
                                    <div class="field__wrap">
                                        <input value="{{ $item->attributes->email }}" readonly autocomplete="off" class="field__area" type="email" name="email" required="required">
                                    </div>
                                    <div class="field__error"></div>
                                </div>
    
                                <div class="auth__field field --sm --b-gray --required">
                                    <div class="field__title --gray">Телефон</div>
                                    <div class="field__wrap">
                                        <input value="{{ $item->attributes->phone }}" readonly autocomplete="off" class="field__area" type="text" name="phone"  inputmode="numeric" required="required">
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
                                            <input value="{{ $item->attributes->order_number }}" readonly autocomplete="off" class="field__area" type="text" name="order_number"  required="required">
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
                                                class="field__area" 
                                                type="text" 
                                                name="order_date" 
                                                required="required"
                                                disabled
                                                value="{{ date('d.m.Y', strtotime($item->attributes->order_date))  }}"
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
                                    @if(isset($item->relationships->userRows))
                                        @foreach( $item->relationships->userRows as $row )
                                            <div class="row list-row itemRow"  data-row-id="1">
                                                <div class="row__cell --text-center list-row-num">
                                                    {{$loop->index + 1}}
                                                </div>
                                                <div class="row__cell">
                                                    <input
                                                        required
                                                        type="text"
                                                        autocomplete="off"
                                                        placeholder="Артикул товара"
                                                        readonly
                                                        value="{{ $row->attributes->article }}"
                                                    >
                                                </div>
                                                <div class="row__cell --item-name">
                                                    <input
                                                        required
                                                        name="rows[1][name]"
                                                        type="text"
                                                        autocomplete="off"
                                                        placeholder="Название товара"
                                                        readonly
                                                        value="{{ $row->attributes->product_name }}"
                                                    >
                                                </div>
                                                <div class="row__cell --text-center">
                                                    <input
                                                        required
                                                        name="rows[1][size]"
                                                        type="text"
                                                        autocomplete="off"
                                                        placeholder="Размер"
                                                        readonly
                                                        value="{{ $row->attributes->size }}"
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
                                                        readonly
                                                        value="{{ $row->attributes->quantity }}"
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
                                                        readonly
                                                        value="{{ $row->attributes->price }}"
                                                    >
                                                </div>
                                                <div class="row__cell --item-name">
                                                    @foreach($returnReasonsList as $returnReason)
                                                        @if($returnReason->id == $row->attributes->reason_return_id)
                                                            <input
                                                                class="itemSum"
                                                                required
                                                                autocomplete="off"
                                                                readonly
                                                                value="{{$returnReason->attributes->name}}"
                                                            >
                                                        @endif
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                            <div class="info --mt-10 sum">
                                На основании вышеизложенного, в соответствии с Законом РФ «О защите прав потребителей» № 2300-1
                                от 07.02.92 г., прошу расторгнуть со мной договор купли-продажи и возвратить сумму в размере:
                                <div class="field__wrap --inline-block ">
                                    <div class="auth__field field --sm --b-gray --required">
                                        <input 
                                            value="{{$total}}" 
                                            disabled 
                                            class="totalBlock field__area" 
                                            type="text" 
                                            name="sum" 
                                            required
                                            
                                        />
                                    </div>
                                </div>руб
                            </div>
                            <label  class="auth__checkbox checkbox --sm --b-gray">
                                <input 
                                    name="pay-type" 
                                    value="1" 
                                    class="checkbox__input" 
                                    type="radio" 
                                    @if($item->attributes->document_return_request_type_id === 1) checked @endif
                                    disabled
                                >
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
                            <label  class="auth__checkbox checkbox --sm --b-gray">
                                <input 
                                    name="pay-type" 
                                    value="2" 
                                    class="checkbox__input" 
                                    type="radio" 
                                    @if($item->attributes->document_return_request_type_id === 2) checked @endif
                                    disabled
                                >
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
    
                            <div id="return-page__person" class="return-page__person @if($item->attributes->document_return_request_type_id === 1) d-none @endif" style="margin-top: 50px;">
                                <div class="auth__field field --sm --b-gray --required">
                                    <div class="field__title --gray">ФИО</div>
                                    <div class="field__wrap">
                                        <input value="{{ $item->attributes->recipient_fio }}" readonly id="fio" class="field__area" type="text" name="fio">
                                    </div>
                                    <div class="field__error"></div>
                                </div>
    
                                <div class="auth__field field --sm --b-gray --required">
                                    <div class="field__title --gray">БИК</div>
                                    <div class="field__wrap">
                                        <input value="{{ $item->attributes->bik }}" readonly id="bik" class="field__area" type="text" name="bik">
                                    </div>
                                    <div class="field__error"></div>
                                </div>
    
                                <div class="auth__field field --sm --b-gray --required">
                                    <div class="field__title --gray">Номер счета получателя</div>
                                    <div class="field__wrap">
                                        <input value="{{ $item->attributes->bank }}" readonly id="bank" class="field__area" type="text" name="bank">
                                    </div>
                                    <div class="field__error"></div>
                                </div>

                                
                            </div>
                        </div>
                        <p class="info noprint">
                            Вы можете оформить возврат товара в течение 7 дней с момента получения заказа при условии сохранения его
                            товарного вида (ФЗ «О защите прав потребителей» ст. 26 1. п.4). Для этого заполните ниже представленную форму
                            возврата и вложите бланк в посылку с товарами, которые хотите вернуть.
                        </p>
                    </div>


                    <div class="success-modal --show"  data-barcode="{{ $item->attributes->return_barcode }}">
                        <div class="success-modal__bg"></div>
                        <div class="success-modal__wrapper">
                            <div class="success-modal__inner">
                                <div class="success-modal__title">
                                Ваше заявление принято! 
                                    <span onclick="hideSuccessModal()">X</span>
                                </div>
                                <div onclick="hideSuccessModal()" class="success-modal__button  button --sm --bg-primary">Спасибо</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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

    </div>
</body>
</html>