<link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}">
<link rel="stylesheet" href="{{ asset('css/app.css') }}">

<main class="m-4">
    <h2>You have received a message from 
        <a href="/profile/{{ $details['userId'] }}">{{ $details['userName'] }}</a> 
        about the listing 
        "<a href="/product/{{ $details['productId'] }}">{{ $details['productName'] }}</a>"
    </h2>

    <div>
        <p>{{ $details['userName'] }} wrote:</p>
        <p>"{{ $details['body'] }}"</p>
    </div>
   
    <a class="button button-primary" href="/chat/">Send a reply</a>
</main>