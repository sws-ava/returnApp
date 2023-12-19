<!DOCTYPE html>
<html>
<head>
    <title>Возврат товара от {{ date('d.m.Y') }}</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
    <style>
        *{
            font-family: DejaVu Sans;
            font-size: 12px;
            letter-spacing: -0.5px;
        }
        ul{
            list-style: none;
        }
        li{
            margin-top: 10px;
        }
    </style>
    <div style="width: 100%; max-width: 960px; margin: auto">
    <table width="100%">
        <tr>
            <td rowspan="4" style="width: 50%; font-size: 24px;">
            <span style="width:255px;text-align: center; display: block; margin-bottom: 10px;font-size: 24px;">SELFMADE</span>
            @php
                $generator = new Picqer\Barcode\BarcodeGeneratorHTML();
                $returnBarcode = $data->attributes->return_barcode;
            @endphp
            
            {!! $generator->getBarcode($returnBarcode, $generator::TYPE_CODE_128) !!}
            <span style="width:255px;text-align: center; display: block; margin-top: 10px;">{{$data->attributes->return_barcode}}</span>
        </td>
            <td style="">ООО «Инстита»</td>
        </tr>
        <tr>
            <td style="border-bottom: 1px solid  #d9d9d9;"><span style=" font-size: 10px">ФИО</span>: {{$data->attributes->client_fio}}</td>
        </tr>
        <tr>
            <td style="border-bottom: 1px solid  #d9d9d9;"><span style=" font-size: 10px">E-MAIL</span>: {{$data->attributes->email}}</td>
        </tr>
        <tr>
            <td style="border-bottom: 1px solid  #d9d9d9;"><span style=" font-size: 10px">ТЕЛЕФОН</span>: {{$data->attributes->phone}}</td>
        </tr>
    </table>
    <p>
        Вы можете оформить возврат товара в течение 7 дней с момента получения заказа при условии сохранения его
        товарного вида (ФЗ «О защите прав потребителей» ст. 26 1. п.4). Для этого заполните ниже представленную форму
        возврата и вложите бланк в посылку с товарами, которые хотите вернуть.
    </p>
    <p style="margin: 30px 0px; font-size: 20px; text-align: center">Заявление на возврат</p>
    <table width="100%">
        <tr>
            <td style="width: 40%; border-bottom: 1px solid  #d9d9d9; padding: 5px 10px;"><span style=" font-size: 10px">Номер заказа</span>: {{$data->attributes->order_number}}</td>
            <td style="width: 20%"></td>
            <td style="width: 40%; border-bottom: 1px solid  #d9d9d9; padding: 5px 10px;"><span style=" font-size: 10px">Дата доставки заказа</span>: {{$data->attributes->order_date}}</td>
        </tr>
    </table>
    <br>
    <table width="100%" cellpadding="0" cellspacing="0" border="1">
        <tr>
            <td style="text-align: center; padding: 5px 10px;">№</td>
            <td style="text-align: center; padding: 5px 10px;">Артикул</td>
            <td style="text-align: center; padding: 5px 10px;">Наименование</td>
            <td style="text-align: center; padding: 5px 10px;">Раз-<br>мер</td>
            <td style="text-align: center; padding: 5px 10px;">Коли-<br>чество</td>
            <td style="text-align: center; padding: 5px 10px;">Стоимость</td>
            <td style="text-align: center; padding: 5px 10px;">Причина <br> возврата</td>
        </tr>
        @foreach ($data->relationships->userRows as $product)
            <tr>
                <td style="text-align: center; padding: 5px 10px;">{{ $loop->index + 1 }}</td>
                <td style="text-align: left; padding: 5px 10px;">{{ $product->attributes->article }}</td>
                <td style="text-align: left; padding: 5px 10px;">{{ $product->attributes->product_name }}</td>
                <td style="text-align: center; padding: 5px 10px;">{{ $product->attributes->size }}</td>
                <td style="text-align: center; padding: 5px 10px;">{{ $product->attributes->quantity }}</td>
                <td style="text-align: center; padding: 5px 10px;">{{ $product->attributes->price }}</td>
                <td style="text-align: center; padding: 5px 10px;">
                    @foreach($returnReasonsList as $item)                        
                        @if($item->id == $product->attributes->reason_return_id)
                            {{$item->attributes->name}}
                        @endif
                    @endforeach
                </td>
            </tr>
        @endforeach

        
        </table>
        <br><br>
        <p>
            На основании вышеизложенного, в соответствии с Законом РФ «О защите прав потребителей» № 2300-1
            от 07.02.92 г., прошу расторгнуть со мной договор купли-продажи и возвратить сумму в размере: {{$total}} руб
        </p>
        <p>
            <span style="display: inline-block; min-width: 15px;">@if($data->attributes->document_return_request_type_id == 1)&#10003;@endif</span> Оплачивала картой на сайте. Прошу перечислить денежные средства на карту, с которой они были списаны.
        </p>
        <p>
            <span style="display: inline-block; min-width: 15px;">@if($data->attributes->document_return_request_type_id == 2)&#10003;@endif</span> Оплачивала курьеру при получении. Прошу перечислить денежные средства по реквизитам:
        </p>
        @if($data->attributes->document_return_request_type_id == 2)
        <table width="100%">
            <tr>
                <td style="padding-top: 10px;border-bottom: 1px solid  #d9d9d9;"><span style=" font-size: 10px">ФИО</span>: {{$data->attributes->fio}}</td>
            </tr>
            <tr>
                <td style="padding-top: 10px;border-bottom: 1px solid  #d9d9d9;"><span style=" font-size: 10px">БИК</span>: {{$data->attributes->bik}}</td>
            </tr>
            <tr>
                <td style="padding-top: 10px;border-bottom: 1px solid  #d9d9d9;"><span style=" font-size: 10px">Номер счета получателя</span>: {{$data->attributes->bank}}</td>
            </tr>
        </table>
        <br><br>
        @endif
        <table  width="100%">
            <tr>
                <td style="padding-top: 10px;border-bottom: 1px solid  #d9d9d9;"><span style=" font-size: 10px">Дата</span>: {{ date('d.m.Y') }}</td>
                <td width="30%" style="padding-top: 10px;"></td>
                <td style="padding-top: 10px;border-bottom: 1px solid  #d9d9d9;"><span style=" font-size: 10px">Подпись</span></td>
            </tr>
        </table>
        <br><br>
        <div class="self-return">
            <p class="self-return__desc">
                Возврат товара возможен в течение 7 календарных дней с даты получения заказа.
                <br>
                Возврат товара возможен, если сохранен документ, подтверждающий покупку (чек) и товарный вид: сохранены этикетка, ярлык, потребительские свойства
            </p>
            <div class="self-return__title" style="font-size: 18px">Самостоятельный возврат
            </div>
            <br>
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
    </div>
    <script>
        console.log('asdasd');
    </script>
</body>
</html>