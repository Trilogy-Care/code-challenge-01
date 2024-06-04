<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        <!-- Styles -->
        <script src="https://cdn.tailwindcss.com"></script>
    </head>
    <body class="antialiased">
        <div class="flex w-screen h-screen justify-center">
            <main class="max-w-3xl w-full flex flex-col gap-y-6 p-6">
                <h1 class="text-3xl font-medium">Bills</h1>
                <div class="grid grid-cols-3 gap-6">
                    <div class="border p-4 rounded-lg w-full flex flex-col items-center">
                        <span class="text-xl font-medium">{{\App\Models\Bill::byStageLabel('submitted')->count()}}</span>
                        <span class="text-sm">Total # of submitted bills</span>
                    </div>
                    <div class="border p-4 rounded-lg w-full flex flex-col items-center">
                        <span class="text-xl font-medium">{{\App\Models\Bill::byStageLabel('approved')->count()}}</span>
                        <span class="text-sm">Total # of approved bills</span>
                    </div>
                    <div class="border p-4 rounded-lg w-full flex flex-col items-center">
                        <span class="text-xl font-medium">{{\App\Models\Bill::byStageLabel('on hold')->count()}}</span>
                        <span class="text-sm">Total # of on hold bills</span>
                    </div>
                </div>
                <div class="border p-4 rounded-lg w-full">
                    <table class="w-full">
                        <thead>
                            <th>Name</th>
                            <th>Total bills</th>
                            <th>Total submitted</th>
                            <th>Total approved</th>
                        </thead>
                        <tbody>
                            @foreach(\App\Models\User::all() as $user)
                            <tr>
                                <td align="center">{{$user->name}}</td>
                                <td align="center">{{$user->bills()->count()}}</td>
                                <td align="center">{{$user->bills()->byStageLabel('submitted')->count()}}</td>
                                <td align="center">{{$user->bills()->byStageLabel('approved')->count()}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </main>
        </div>
    </body>
</html>
