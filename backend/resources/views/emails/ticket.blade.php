<x-mail::message>
# 🎉 Votre billet est confirmé !

Bonjour **{{ $issuedTicket->holder_name }}**,

Merci pour votre achat. Voici votre billet pour le **{{ $festivalName }}**.

---

<x-mail::panel>
**{{ $issuedTicket->ticket_name }}**

- **Identifiant unique :** `{{ $issuedTicket->uid }}`
- **Titulaire :** {{ $issuedTicket->holder_name }}
- **Montant payé :** {{ number_format($issuedTicket->price_paid, 0, ',', ' ') }} {{ $issuedTicket->currency }}
- **Statut :** ✅ Valide
</x-mail::panel>

---

## 📅 Informations festival

| | |
|---|---|
| **Festival** | {{ $festivalName }} |
| **Dates** | {{ $festivalDates }} |
| **Lieu** | {{ $festivalVenue }} |

---

## 📲 QR Code d'accès

Présentez ce QR code à l'entrée du festival. **Ne le partagez pas.**

<div style="text-align:center; margin: 20px 0;">
  <img src="data:image/png;base64,{{ $qrCodeBase64 }}" alt="QR Code {{ $issuedTicket->uid }}" width="200" style="border: 4px solid #C9A84C; border-radius: 8px;" />
  <br>
  <small style="color: #888; font-family: monospace;">{{ $issuedTicket->uid }}</small>
</div>

---

> En cas de problème, contactez-nous en indiquant votre identifiant de billet : **{{ $issuedTicket->uid }}**

À très bientôt sur la piste de danse ! 🕺

**L'équipe {{ $festivalName }}**
</x-mail::message>
