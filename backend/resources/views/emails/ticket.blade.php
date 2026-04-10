<x-mail::message>
# Votre billet est confirmé !

Bonjour **{{ $issuedTicket->holder_name }}**,

Merci pour votre achat. Voici votre billet pour le **{{ $festivalName }}**.

---

@if ($ticketImageBase64)
<div style="text-align:center; margin: 24px 0;">
  <img
    src="data:image/jpeg;base64,{{ $ticketImageBase64 }}"
    alt="Billet {{ $issuedTicket->uid }}"
    style="max-width:100%; border-radius:10px; box-shadow: 0 4px 16px rgba(0,0,0,0.3);"
  />
  <p style="color:#888; font-size:12px; margin-top:8px; font-family:monospace;">
    {{ $issuedTicket->uid }}
  </p>
</div>
@else
{{-- Fallback : QR code seul si l'image composite n'a pas pu être générée --}}
<x-mail::panel>
**{{ $issuedTicket->ticket_name }}**

- **Identifiant :** `{{ $issuedTicket->uid }}`
- **Titulaire :** {{ $issuedTicket->holder_name }}
- **Montant payé :** {{ number_format($issuedTicket->price_paid, 0, ',', ' ') }} {{ $issuedTicket->currency }}
</x-mail::panel>

<div style="text-align:center; margin: 20px 0;">
  <img src="data:image/png;base64,{{ $qrCodeBase64 }}" alt="QR Code" width="200" style="border: 4px solid #C9A84C; border-radius: 8px;" />
  <br>
  <small style="color:#888; font-family:monospace;">{{ $issuedTicket->uid }}</small>
</div>
@endif

---

<x-mail::panel>
| | |
|---|---|
| **Festival** | {{ $festivalName }} |
| **Dates** | {{ $festivalDates }} |
| **Lieu** | {{ $festivalVenue }} |
| **Statut** | Valide |
</x-mail::panel>

> Votre billet est également joint en pièce jointe. Présentez-le à l'entrée du festival. **Ne le partagez pas.**

En cas de problème, contactez-nous en indiquant la référence : **{{ $issuedTicket->uid }}**

À très bientôt sur la piste de danse !

**L'équipe {{ $festivalName }}**
</x-mail::message>
