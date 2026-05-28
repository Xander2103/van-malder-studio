<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Nieuwe aanvraag ontvangen</title>
</head>
<body style="font-family: sans-serif; color: #0f172a; line-height: 1.6;">
    <h2>Nieuwe aanvraag — Van Malder Studio</h2>
    <p><strong>Naam:</strong> {{ $inquiry->name }}</p>
    @if($inquiry->company_name)
    <p><strong>Bedrijf:</strong> {{ $inquiry->company_name }}</p>
    @endif
    <p><strong>E-mail:</strong> {{ $inquiry->email }}</p>
    @if($inquiry->phone)
    <p><strong>Telefoon:</strong> {{ $inquiry->phone }}</p>
    @endif
    <p><strong>Projecttype:</strong> {{ $inquiry->project_type }}</p>
    @if($inquiry->budget_range)
    <p><strong>Budget:</strong> {{ $inquiry->budget_range }}</p>
    @endif
    @if($inquiry->timeline)
    <p><strong>Timing:</strong> {{ $inquiry->timeline }}</p>
    @endif
    <hr>
    <p><strong>Projectomschrijving:</strong></p>
    <p>{{ $inquiry->project_description }}</p>
</body>
</html>
