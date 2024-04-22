<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <section>
        <div class="table">
            <table border="1">
                <thead>
                    <tr>
                        <th>Naam</th>
                        <th>Prijs</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($products as $product)
                    <tr>
                        <td>{{$product->name}}</td>
                        <td>{{$product->price->price}}</td>
                        <td><a href="#">Edit</a></td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="2">{{__('Er zijn geen producten.')}}</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
</body>

</html>