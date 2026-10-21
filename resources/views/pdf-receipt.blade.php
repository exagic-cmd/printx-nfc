<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" href="{{asset('css/style.css')}}">
        <title>Receipt</title>
    </head>
    <body>
        <div class="copy">
    <h3>Copy</h3>
    <p>{{$receipt->date}}</p>
    <p>{{$receipt->time}}</p>
</div>
    <div class="ticket pdf-w show card-body">
        
                      <img class="barcode hidden" id="barcode1" src="{{ asset('barcode.png') }}" alt="barcode">
                      <img class="logo" src="{{ asset('logo.png') }}" alt="Logo">
                      <p class="centered" style="margin-top: 10px;margin-bottom:3px; font-weight: 600">حكومة الشارقة
                          <br>ه‍ينة ا لطرق و المواصلات دالرة ا لما لية المركزية
                          <br>  نظام التعرفة المرورية للشاحنات   &nbsp;&nbsp;&nbsp;  نظا م تحصيل
                      </p>
                      <p style="margin-top: 0;text-align: right;padding-right:52px;height:2px" id="titleTop">
                          {{ $receipt->gate }}
                      </p>
                      <p class="centered" style="height: 0px;font-family: auto;">(Payment Receipt)</p>
                      <p class="centered" style="height: 3px; font-family: auto;">Tax Invoice / فاتورة قضريبية
                      </p>
                      <p class="centered" style="height: 3px; font-family: auto;">TRN: <span id="trn">{{ $receipt->trn }}</span></p>
                      <table>
                          <tbody>
                              <tr>
                                  <td class="description" style="direction:rtl" id="tim">{{ $receipt->time }}</td>
                                  <td class="description"style="width: 1px;">:الوقت</td>
                                  <td class="description" style="width: 114px;" >&nbsp;&nbsp;&nbsp;:التاريخ<span style="font-size:13px;padding-right: 5px;" id="dte">{{ $receipt->date }}</span></td>
                              </tr>
                              <tr>
                                  <td class="description" colspan="3" >رقم الايصال:&nbsp;&nbsp;<span id="amt">{{ $receipt->receipt_number }}</span></td>
                              </tr>
                              <tr>
                                  <td class="description" colspan="3"><span>نوع لخدمة:&nbsp;&nbsp;&nbsp;&nbsp;</span>رسوم عبور شاحنة مع مقطورة</td>
                              </tr>
                              <tr>
                                  <td class="description" colspan="3">&nbsp;&nbsp;اسم المالك :&nbsp;<span id="vName">{{ $receipt->owner_name }}</span>&nbsp;</td>
                              </tr>
                              <tr>
                                  <td class="description" colspan="3" ><span id="vNo"style="display: inline-block;">{{ $receipt->vehicle_number }}</span>&nbsp;&nbsp;&nbsp;&nbsp;:رقم المركبة</td>
                              </tr>
                              <tr>
                                  <td class="description"  colspan="2"><span class="pdL33">درهم&nbsp;&nbsp;<span id="tAmt" style="display: inline-block;"> {{ $receipt->total_amount }}</span></span></td>
                                  <td class="description" colspan="1"><span></span>:اجمالى المبلغ </td>
                              </tr>
                              <tr>
                                  <td class="quantity" colspan="1">&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                  <td class="description" colspan="2">رسوم اخرى</td>
                              </tr>
                              <tr>
                                  <td class="quantity" colspan="1">درهم&nbsp;&nbsp;<span id="temAmt" style="display: inline-block;">{{ $receipt->research_support }}</span></td>
                                  <td class="description" colspan="4"><p style="font-size:12px; margin:0">:دعم الا بحات العلمية فى امارة الشارقة</p></td>
                              </tr>
                              <tr>
                                  <td class="quantity" colspan="1">درهم&nbsp;&nbsp;<span id="charAmt" style="display: inline-block;">{{ $receipt->collection_fee }}</span></td>
                                  <td class="description" colspan="4">:رسوم خدمت تحصيل</td>
                              </tr>
                              <tr>
                                  <td class="quantity"colspan="1">درهم&nbsp;&nbsp;<span id="lstAmt" style="display: inline-block;">{{ $receipt->vat }}</span></td>
                                  <td class="description" colspan="4">:رسوم طرمية النيمة المضا فة</td>
                              </tr>
                          </tbody>
                      </table>
                      <p class="centered" style="height: 3px;font-family: auto;"> Gate<span id="gNo">{{ $receipt->user_name }}</span>:اسم لستخدم</p>
                      <p class="centered" style="height: 3px; font-size: 12px"> ملاحظه:   ير جى لا حنفاظ يايصال تحصيل ندواعى امية</p>
                      <div id="qrCode" class="barcode" >
                      {!! $qrCode !!}
                  </div>     
        
    </body>

    <script>
    document.addEventListener("DOMContentLoaded", function () {
        document.getElementById("previewPdf").addEventListener("click", function () {
            const { jsPDF } = window.jspdf;
            let pdf = new jsPDF('p', 'mm', 'a4');

            html2canvas(document.querySelector(".ticket")).then(canvas => {
                let imgData = canvas.toDataURL("image/png");
                let imgWidth = 190;
                let imgHeight = (canvas.height * imgWidth) / canvas.width;
                let position = 10;

                pdf.addImage(imgData, 'PNG', 10, position, imgWidth, imgHeight);
                window.open(pdf.output('bloburl'), '_blank'); // Open PDF in a new tab
            });
        });
    });
</script>

<button id="previewPdf">Preview PDF</button>




</html>