<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tahseel Digital Payment System</title>
	<link rel="icon" type="image/x-icon" href="{{asset('favicon.png')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <link rel="stylesheet" href="{{asset('css/scan-style.css')}}" />
</head>
<body>
<div id="preloader">
        <img src="{{asset('favicon.png')}}" alt="Loading..." id="preloader-logo">
    </div>
	<div class="container-fluid g-0">
    <div class="hero ">
		<div class="container">
        <div class="navbar">
            <div class="logo">
				<img src="{{asset('logo-white.png')}}">
				
			</div>
			<div>
            <ul class="nav-links">
                <li><a href="#">Home</a></li>
                <li><a href="#">Services</a></li>
                <li><a href="#">Tahseel</a></li>
                <li><a href="#">News & Events</a></li>				
                <li><a href="#">Login</a></li>
            </ul>
	</div>
            
			
        </div>
		<div class="menu-icon">
        <img src="{{asset('logo-white.png')}}">
            </div>
		<div>
			<h1>Tahseel Receipt Details</h1>
			<h5>Home / Tahseel Receipt Details</h5>
			</div>
		
	</div>
    </div>
    <div class="container">
	<div class="payment">
			<h2 class="text-dark mb-4">Payment Transaction</h2>
			<ul>
			<li class="text-warning mb-1 font-size-h6">Please check the below information with the paper receipt and below print receipt.</li>
			<li class="text-warning font-size-h6 mb-4">In case any mismatch information, please contact us on the toll free number - 8008247335
				</li>
			</ul>
			<div class="row">
				<div class="col-md-6">
				<label class="font-size-h5 font-weight-bolder text-muted mb-3"> Entity : </label>
				<label class="font-size-h4 font-weight-bolder mx-1 mb-3"> {{ $receipt->entity }} </label>
					<br>
				<label class="font-size-h5 font-weight-bolder text-muted mb-3"> Reference No : </label>
				<label class="font-size-h4 font-weight-bolder mx-1 mb-3"> {{ $receipt->refno }} </label>
					<br>
				<label class="font-size-h5 font-weight-bolder text-muted mb-3"> Application No : </label>
				<label class="font-size-h4 font-weight-bolder mx-1 mb-3"> {{ $receipt->appno }} </label>

				</div>
				<div class="col-md-6">

				<label class="font-size-h5 font-weight-bolder text-muted mb-3"> Receipt No : </label>
				<label class="font-size-h4 font-weight-bolder mx-1 mb-3"> {{ $receipt->receipt_number }} </label>
					<br>
				<label class="font-size-h5 font-weight-bolder text-muted mb-3"> Total Amount : </label>
				<label class="font-size-h4 font-weight-bolder mx-1 mb-3"> {{ $receipt->total_amount }} AED</label>
					<br>
				<label class="font-size-h5 font-weight-bolder text-muted mb-3"> Date : </label>
				<label class="font-size-h4 font-weight-bolder mx-1 mb-3"> {{ $receipt->date }}T{{ $receipt->time }} </label>

				</div>
			</div>
			 
	


<div id="receipt-content">
	<div class="pdf-receipt">
	<div class="copy">
    <h3>Copy</h3>
    <p>{{$receipt->date}}</p>
    <p>{{$receipt->time}}</p>
</div>

    <div class="ticket  show card-body">
        
                      <img class="logo" src="{{ asset('logo.png') }}" alt="Logo">
                      <hr>
                      <p class="centered" style="margin-top: 10px;margin-bottom:3px; font-weight: 600">حكومة الشارقة
                          <br>ه‍ينة ا لطرق و المواصلات دالرة ا لما لية المركزية
                          <br>  نظام التعرفة المرورية للشاحنات   &nbsp;&nbsp;&nbsp;  نظا م تحصيل
                      </p>
                      <p style="margin-top: 0;text-align: right;padding-right:52px;height:2px" id="titleTop">
                          {{ $receipt->gate }}
                      </p>
                      <hr>
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
                      <div class="qrCode">
						@if(!empty($data['qrimage']))
							<img src="{{ $data['qrimage'] }}" alt="QR Code">
						@endif
						</div>
						</div>
	
	</div>
	</div>
	<iframe id="pdfViewer" width="100%" height="600px"></iframe>
   <div class="text-center">
    <button class="btn btn-primary text-center" onclick="openPDF()">Download Receipt <i class="fa-solid fa-print print-icon"></i></button>
    </div>
	</div>
    </div>
	<div id="loading" style="display: none;">Generating PDF...</div>
    <div class="mobile-nav">
    <div class="d-flex j-content">
        <div class="col-xs-4 text-center">
        <i class="fa-solid fa-house"></i>
        </div>
        <div class="col-xs-4 text-center">
            <img src="{{asset('favicon.png')}}"/>
        </div>
        <div class="col-xs-4 text-center">
        <i onclick="openMenu() " class="fa-solid fa-bars"></i>
        </div>
    </div>
    </div>
    <div class="mobile-menu" id="mobileMenu">
        <div class="close-menu" onclick="closeMenu()">&times;</div>
        <div class="tabs">
        <div class="tab active" onclick="openTab(event, 'overview')"><i class="fa-solid fa-user"></i></div>
        <div class="tab" onclick="openTab(event, 'posts')"><i class="fa-solid fa-gear"></i></div>
        <div class="tab" onclick="openTab(event, 'settings')"><i class="fa-solid fa-circle-exclamation"></i></div>
    </div>
    
    <div id="overview" class="tab-content active">
        <div class="d-flex">
        <i class="fa-solid fa-circle-user" style="font-size: 61px;margin-right: 9px;"></i>
        <h3>Hi, <br> Guest</h3>
        </div>
        <ul class="tabs-p">
            <li><i class="fa-solid fa-angle-right"></i>&nbsp;&nbsp;&nbsp; Login</li>
            <li><i class="fa-solid fa-angle-right"></i>&nbsp;&nbsp;&nbsp; Forget username?</li>
            <li><i class="fa-solid fa-angle-right"></i>&nbsp;&nbsp;&nbsp; Forget password?</li>
        </ul>
    </div>
    <div id="posts" class="tab-content">
        <h6>Select Background</h6>
        <div class="d-flex circle j-content">
            <img class="img-circle" src="{{asset('fog1.jpg')}}"/>
            <img src="{{asset('image1.jpg')}}"/>
            <img src="{{asset('image2.jpg')}}"/>
        </div>
    </div>
    <div id="settings" class="tab-content">
    <ul class="tabs-p">
            <li><i class="fa-solid fa-angle-right"></i>&nbsp;&nbsp;&nbsp; Home</li>
            <li><i class="fa-solid fa-angle-right"></i>&nbsp;&nbsp;&nbsp; Services</li>
            <li><i class="fa-solid fa-angle-right"></i>&nbsp;&nbsp;&nbsp; News & Events</li>
            <li><i class="fa-solid fa-angle-right"></i>&nbsp;&nbsp;&nbsp; Service Locations</li>
            <li><i class="fa-solid fa-angle-right"></i>&nbsp;&nbsp;&nbsp; Our Features</li>
            <li><i class="fa-solid fa-angle-right"></i>&nbsp;&nbsp;&nbsp; FAQ's</li>
            <li><i class="fa-solid fa-angle-right"></i>&nbsp;&nbsp;&nbsp; About</li>
            <li><i class="fa-solid fa-angle-right"></i>&nbsp;&nbsp;&nbsp; Terms & Conditions</li>
            <li><i class="fa-solid fa-angle-right"></i>&nbsp;&nbsp;&nbsp; Open Ticket</li>
            <li><i class="fa-solid fa-angle-right"></i>&nbsp;&nbsp;&nbsp; Followup Ticket</li>
        </ul>
    </div>
    </div>
    <script>
        function openMenu() {
            document.getElementById('mobileMenu').style.display = 'flex';
        }
        function closeMenu() {
            document.getElementById('mobileMenu').style.display = 'none';
        }
    </script>
	<script>
   async function generatePDF() {
        document.getElementById('loading').style.display = 'block';
        // document.getElementById('fullpage-preloader').style.display = 'flex';
        const { jsPDF } = window.jspdf;
        const doc = new jsPDF();
        doc.setProperties({
        title: 'Tahseel Receipt'
    });
        // Temporarily show the receipt content for capturing
        const receiptContent = document.getElementById("receipt-content");
        receiptContent.style.position = 'absolute';
        receiptContent.style.left = '0';
        receiptContent.style.top = '0';
        receiptContent.style.visibility = 'visible';

        await html2canvas(receiptContent, { 
            scale: 2,
            logging: true,
            useCORS: true
        }).then((canvas) => {
            const imgData = canvas.toDataURL("image/png");
            const imgWidth = 190;
            const imgHeight = (canvas.height * imgWidth) / canvas.width;

            doc.addImage(imgData, "PNG", 10, 10, imgWidth, imgHeight);
            const pdfBlob = doc.output("blob");
            const pdfUrl = URL.createObjectURL(pdfBlob);
            
            document.getElementById("pdfViewer").src = pdfUrl;
            
            // Hide the receipt content again
            receiptContent.style.position = 'absolute';
            receiptContent.style.left = '-9999px';
            receiptContent.style.top = '-9999px';
            receiptContent.style.visibility = 'hidden';
            
            document.getElementById('loading').style.display = 'none';
        });
    }

    window.onload = function() {
        generatePDF();
    };
</script>

<script>
    function openPDF() {
    // Get the PDF URL from the iframe
    const pdfUrl = document.getElementById("pdfViewer").src;
    
    // Open in new tab
    if (pdfUrl) {
        window.open(pdfUrl, '_blank');
    } else {
        alert("PDF is still being generated. Please wait a moment and try again.");
    }
}
</script>
<script>
window.addEventListener("load", function() {
    let preloader = document.getElementById("preloader");

    setTimeout(() => {
        preloader.style.opacity = "0"; // Apply fade-out effect

        setTimeout(() => {
            preloader.style.display = "none";  // Hide after fade-out
            document.body.style.overflow = "auto"; // Allow scrolling after preloader disappears
        }, 500); // Matches CSS transition time

    }, 1500); // Delay for 1 second before fading out (adjust as needed)
});


</script>
<script>
        function openTab(event, tabName) {
            let i, tabContent, tabLinks;
            tabContent = document.getElementsByClassName("tab-content");
            for (i = 0; i < tabContent.length; i++) {
                tabContent[i].style.display = "none";
            }
            tabLinks = document.getElementsByClassName("tab");
            for (i = 0; i < tabLinks.length; i++) {
                tabLinks[i].classList.remove("active");
            }
            document.getElementById(tabName).style.display = "block";
            event.currentTarget.classList.add("active");
        }
    </script>
</body>


</html>

