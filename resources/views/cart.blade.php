@extends('layouts.app')
@section('content')

    <div class="flex w-full justify-center">

        <div class="flex flex-col p-8 text-gray-800 bg-white shadow-lg pin-r pin-y md:w-4/5 lg:w-9/12">
            
            <div class="flex-1">

                <div class="flex space-x-2 mb-4">
                    <h1 class="text-3xl font-medium">My Cart</h1>    
                    
                    <!-- TODO: Add cart icon like wishlist's. -->  
                </div>

                <!-- Guest user assign to cart from session's array. -->
                @if(session('products') && !auth()->user())

                    <!-- 
                        Add items to cart that will last till session is over for
                        unauthenticated users.
                    -->
                     
                    <!-- Products and Order summary -->
                     <div>
                         
                        <!-- Products table-->
                        @if (count(session('products')))
                        
                            <table class="w-full text-sm lg:text-base" cellspacing="0">

                                <!-- Table headings -->
                                <thead>
                                    <tr class="h-12 uppercase">
                                        <th class="hidden md:table-cell pb-4"></th>
                                        
                                        <th class="text-center pb-4">Product</th>
                                        
                                        <th class="pb-4 text-center pl-4 lg:pl-0 ">
                                            <span class="lg:hidden" title="Quantity">Qtd</span>
                                            <span class="hidden lg:inline">Quantity</span>
                                        </th>
                                        
                                        <th class="text-center pb-4">Unit price</th>
                                                                            
                                    </tr>
                                </thead>

                                    <!-- Table body -->
                                    <tbody>

                                        @foreach (session('products') as $product)

                                            <tr>                                      
                                                <!-- Image -->
                                                <td class="hidden pb-8 md:table-cell">
                                                    <a href="#">
                                                        <img src="/images/products/{{ $product->prod_image }}"
                                                            class="w-28 h-28 rounded" alt="Thumbnail">
                                                    </a>
                                                </td>
                                            
                                                <!-- Name and remove button -->
                                                <td class="pb-8">
                                                        
                                                    <p class="mb-2 text-md text-center font-medium">{{ $product->prod_name }}</p>
                                                    
                                                    <!-- Remove product button -->
                                                    <form action="{{ route('cart.destroy', $product->id) }}" 
                                                        method="POST" class="flex justify-center">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-white text-sm bg-red-600 hover:bg-red-700 rounded-lg p-1">
                                                            <small class="m-2">Remove item</small>
                                                        </button>
                                            
                                                    </form>
                                            
                                                </td>
                                            
                                                <!-- Dynamic Quantity -->
                                                <td class="justify-center md:flex mt-10">
                                                    <div class="w-24 h-10">
                                                        <div class="relative flex flex-row w-full h-8">
                                                            <input type="number" id="quantity" value="1"
                                                                class="w-full font-semibold text-center 
                                                                text-gray-700 bg-gray-200 outline-none 
                                                                focus:outline-none hover:text-black 
                                                                focus:text-black" />
                                                        </div>
                                                    </div>
                                                </td>
                                            
                                                <!-- Unit Price -->
                                                <td class="text-center pb-8">
                                                    <span class="text-sm lg:text-base font-medium">
                                                        £{{ $product->price }}
                                                    </span>
                                                </td>                             
                                            
                                            </tr>

                                        @endforeach

                                    </tbody>
                                
                            </table>   

                            <hr class="pb-6 mt-6">

                            <!-- Un-Authenticated User's Order Details -->

                            <div class="my-4 mt-6 -mx-2 flex justify-center">

                                <div class="lg:px-2 lg:w-1/2">
                                    
                                    <a href="{{ route('checkout') }}">
                                        <button
                                            class="flex justify-center w-full px-10 py-3 font-medium text-white uppercase bg-gray-800 rounded-full shadow item-center hover:bg-gray-700 focus:shadow-outline focus:outline-none">
                                            <svg aria-hidden="true" data-prefix="far" data-icon="credit-card" class="w-8"
                                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                                                <path fill="currentColor"
                                                    d="M527.9 32H48.1C21.5 32 0 53.5 0 80v352c0 26.5 21.5 48 48.1 48h479.8c26.6 0 48.1-21.5 48.1-48V80c0-26.5-21.5-48-48.1-48zM54.1 80h467.8c3.3 0 6 2.7 6 6v42H48.1V86c0-3.3 2.7-6 6-6zm467.8 352H54.1c-3.3 0-6-2.7-6-6V256h479.8v170c0 3.3-2.7 6-6 6zM192 332v40c0 6.6-5.4 12-12 12h-72c-6.6 0-12-5.4-12-12v-40c0-6.6 5.4-12 12-12h72c6.6 0 12 5.4 12 12zm192 0v40c0 6.6-5.4 12-12 12H236c-6.6 0-12-5.4-12-12v-40c0-6.6 5.4-12 12-12h136c6.6 0 12 5.4 12 12z" />
                                            </svg>
                                            <span class="ml-2 mt-5px">Procceed to checkout</span>
                                        </button>
                                    </a>
    
                                </div>
                            </div>

                        @else
                            <p class="p-4 mb-4 text-md font-bold text-gray-700">
                                You have not added any items to your cart yet.
                            </p>
                        @endif

                        
                    </div>

                @else

                    <!-- Get cart items from database for authenticated users -->

                    <!-- Products and Order summary -->
                    <div>
                        <!-- Products table-->
                        @if ($products->count())
                            
                            <table class="w-full text-sm lg:text-base" cellspacing="0">

                                <!-- Table headings -->
                                <thead>
                                    <tr class="h-12 uppercase">
                                        <th class="hidden md:table-cell pb-4"></th>
                                        
                                        <th class="text-center pb-4">Product</th>
                                        
                                        <th class="pb-4 text-center pl-4 lg:pl-0 ">
                                            <span class="lg:hidden" title="Quantity">Qtd</span>
                                            <span class="hidden lg:inline">Quantity</span>
                                        </th>
                                        
                                        <th class="text-center pb-4">Unit price</th>
                                                                            
                                    </tr>
                                </thead>

                                    <!-- Table body -->
                                    <tbody>

                                        @foreach ($products as $product)

                                            <tr>
                                                
                                                <!-- Image -->
                                                <td class="hidden pb-8 md:table-cell">
                                                    <a href="#">
                                                        <img src="/images/products/{{ $product->prod_image }}"
                                                            class="w-28 h-28 rounded" alt="Thumbnail">
                                                    </a>
                                                </td>

                                                <!-- Name and remove button -->
                                                <td class="pb-8">
                                                        
                                                    <p class="mb-2 text-center text-md font-medium">{{ $product->prod_name }}</p>
                                                    
                                                    <!-- Remove product button -->
                                                    <form action="{{ route('cart.destroy', $product->product_id) }}" method="POST"
                                                    class="flex justify-center"    
                                                    >
                                                        
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-white text-sm hover:bg-red-700 bg-red-600 rounded-lg p-1">
                                                            <small class="m-2">Remove item</small>
                                                        </button>

                                                    </form>

                                                </td>

                                                <!-- Dynamic Quantity -->
                                                <td class="justify-center md:flex mt-10">
                                                    <div class="w-24 h-10">
                                                        <div class="relative flex flex-row w-full h-8">
                                                            <input name="quantity" id="quantity" type="number" value='1' min="1"
                                                                class="w-full font-semibold text-center text-gray-700 bg-gray-200 outline-none focus:outline-none hover:text-black focus:text-black" />
                                                        </div>
                                                    </div>
                                                </td>

                                                <!-- Unit Price -->
                                                <td class="text-center pb-8">
                                                    <span class="text-sm lg:text-base font-medium">
                                                        £{{ $product->price }}
                                                    </span>
                                                </td>

                                            </tr>

                                        @endforeach

                                    </tbody>
                                
                            </table>   

                        @else
                            <p class="p-4 mb-4 text-md font-bold text-gray-700">
                                You have not added any items to your cart yet.
                            </p>
                        @endif

                        <hr class="pb-6 mt-6">

                        <!-- Order Details -->
                        <div class="my-4 mt-6 -mx-2 flex justify-center">

                            <div class="lg:px-2 lg:w-1/2">
                                
                                <a href="{{ route('checkout') }}">
                                    <button
                                        class="flex justify-center w-full px-10 py-3 font-medium text-white uppercase bg-gray-800 rounded-full shadow item-center hover:bg-gray-700 focus:shadow-outline focus:outline-none">
                                        <svg aria-hidden="true" data-prefix="far" data-icon="credit-card" class="w-8"
                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                                            <path fill="currentColor"
                                                d="M527.9 32H48.1C21.5 32 0 53.5 0 80v352c0 26.5 21.5 48 48.1 48h479.8c26.6 0 48.1-21.5 48.1-48V80c0-26.5-21.5-48-48.1-48zM54.1 80h467.8c3.3 0 6 2.7 6 6v42H48.1V86c0-3.3 2.7-6 6-6zm467.8 352H54.1c-3.3 0-6-2.7-6-6V256h479.8v170c0 3.3-2.7 6-6 6zM192 332v40c0 6.6-5.4 12-12 12h-72c-6.6 0-12-5.4-12-12v-40c0-6.6 5.4-12 12-12h72c6.6 0 12 5.4 12 12zm192 0v40c0 6.6-5.4 12-12 12H236c-6.6 0-12-5.4-12-12v-40c0-6.6 5.4-12 12-12h136c6.6 0 12 5.4 12 12z" />
                                        </svg>
                                        <span class="ml-2 mt-5px">Procceed to checkout</span>
                                    </button>
                                </a>

                            </div>
                        </div>
                    </div>
                @endif       
        </div>
    </div>

    <script>

        var totalQuantity = document.getElementById('total-quantity');

        function changeTotalQuantity() {
            
            var selectQuantity = document.getElementById('quantity');
            console.log(selectQuantity.options[selectQuantity.selectedIndex].value);

        }

    </script>
    
@endsection
