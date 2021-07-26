<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Send a message to ' . $product->name . ' about their listing: ' . $product->title) }}
        </h2>
    </x-slot>

    <main class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 d-flex flex-column align-items-center">
            <div class="alert alert-success w-100" style="display:none">
                {{ Session::get('success') }}
            </div>
            <div class="w-100 m-4 bg-white overflow-hidden shadow-sm sm:rounded-lg" style="background-image: url('/storage/{{ $product->product_thumbnail }}'); background-size: cover; background-position: center;">
                <div class="p-4 pt-0 w-100">
                    @csrf
                    <div class="pt-0">
                        <label for="message"></label>
                        <textarea class="w-100 p-2" name="message" id="message" rows="10" placeholder="Write a message" autofocus></textarea>
                    </div>
                    <div class="text-right">
                        <button id="send" data-product_id="{{ $product->product_id }}" data-user_id="{{ Auth::id() }}" class="m-4 mb-2 btn btn-primary text-white" type="submit">Send message</button>
                    </div>
                </div>
            </div>
        </div>
    </main>
</x-app-layout>

<script>
    $( document ).ready(function(){
        $('#send').on('click', function(e){
            var productId = $(this).data('product_id');
            var userId = $(this).data('user_id');
            var message = $('#message').val();
            
            $.ajax({
                type: "GET",
                url: '/chat/' + productId + '/' + userId,
                data: {message: message},
                success: function(data){
                    $(".alert-success").css("display", "block");
                    $('.alert-success p').remove();
                    $(".alert-success").append("<p>Your message was sent successfully, you will be notified via email when the seller sends a reply. You can access the thread <a class='underline' href='/chat'>here</a>.</p>");
                    $('#message').val('');
                },
            });
        })
    });
</script>