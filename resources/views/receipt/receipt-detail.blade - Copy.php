<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <title>Receipt Detail</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap" rel="stylesheet">
</head>
<body>
    
    <div class="frm hidden-print receipt-detail">
    	<div class="header">
        <h3>Tahseel gov ae</h3>
		<p>Click Open & Download receipt</p>
		<a href="{{ route('receipt.pdf-receipt', $receipt->id) }}" class="btn btn-main">Open</a>
		<div class="clearfix"></div>
		<img src="{{asset('header-r.webp')}}">
		</div>
		<div class="body">
			<div class="payment">
			<h2>Payment Transaction</h2>
			<h5>Please check the below information with the paper receipt and below print receipt.<br>
				In case any mismatch information, please contact us on the toll free number - 8008247335
			 </h5>
			 <h6><span>Entity:</span></h6>
			 <h6><span>&nbsp</span>{{ $receipt->entity }}</h6>
			 <h6><span>Reference No:</span> {{ $receipt->refno }}</h6>
			 <h6><span>Application No:</span> {{ $receipt->appno }}</h6>
			 <h6><span>Receipt No:</span> {{ $receipt->receipt_number }}</h6>
			 <h6><span>Total Amount:</span> {{ $receipt->total_amount }}</h6>
			 <h6><span>Date:</span> {{ $receipt->date }}T{{ $receipt->time }}</h6>
			 </div>
		</div>
    </div>

    <!-- Display Area for Receipt -->
    <!-- <div id="receiptDisplay" class="ticket">
    </div> -->
</body>
</html>