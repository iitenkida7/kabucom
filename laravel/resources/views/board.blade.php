<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="https://unpkg.com/mvp.css">
  <title>board | {{$info['SymbolName']}}</title>
</head>
<body>
  <main>
    <h1>{{$info['SymbolName']}}</h1>
    <table>
    @foreach ($info as $key => $value)
      @if (is_array($value))
          @continue
      @endif
      <tr>
      <td>{{ $key }}</td>
      <td>{{ $value }}</td>
      <tr>
    @endforeach
  </table>
  </main>
</body>