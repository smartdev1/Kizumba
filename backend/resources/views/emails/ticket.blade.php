<x-mail::message>
# Votre billet est confirmé !

Bonjour **{{ $issuedTicket->holder_name }}**,

Merci pour votre achat de pass pour le **{{ mb_strtoupper($festivalName) }}**.

✨ Toute l'équipe UKWC est heureuse de vous confirmer votre participation à cet événement international exceptionnel, qui se tiendra à {{ $festivalVenue }} du {{ $festivalDates }}.

Préparez-vous à vivre une expérience unique mêlant danse, culture, rencontres internationales et good vibes, au cœur de l'une des destinations les plus vibrantes d'Afrique de l'Ouest.

---

## 📍 Informations générales

| | |
|---|---|
| **Festival** | {{ mb_strtoupper($festivalName) }} |
| **Lieu** | {{ $festivalVenue }} |
| **Dates** | {{ $festivalDates }} |
| **Durée** | 6 Jours d'immersion totale |
| **Statut** | Valide |

> Au programme : workshops, masterclass, soirées sociales, gala, expériences culturelles et compétitions internationales.

---

## 🗺️ Les sites officiels du UKWC 2026

<x-mail::panel>
**Studio UNITED KIZDOM**
- Workshops & trainings
- Sessions d'apprentissage et de pratique
- Rencontres artistiques entre danseurs

**Salles du Majestic**
- Soirées sociales principales
- Événements majeurs du congrès

**Qualifications africaines de THE BATTLE KIZZ**
- Compétitions & performances internationales

**Byblos & Sofitel**
- Soirées spéciales premium
- Espaces haut de gamme
- Networking international

**Hôtel Azalai (Piscine)**
- Gala officiel du UKWC 2026
- Soirée élégante & performances artistiques
</x-mail::panel>

---

## 🛬 Accueil des participants

<x-mail::panel>
Un dispositif d'accueil est prévu pour faciliter votre arrivée :

- Accueil à l'aéroport international de Cotonou
- Accueil à la gare routière (participants sous-région)
- Assistance & orientation vers votre hébergement
- Organisation de navettes si nécessaire

Si vous avez besoin d'un transfert, merci de nous transmettre :

- Date et heure d'arrivée
- Numéro de vol / compagnie
- Lieu de résidence
- Nombre de personnes
- Numéro WhatsApp

Notre équipe logistique vous contactera pour organiser votre arrivée dans les meilleures conditions.
</x-mail::panel>

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

## 🌍 À la découverte du Bénin

Le Bénin est une destination riche en histoire, culture et traditions :

- Ancien Royaume du Dahomey
- Berceau du Vodun
- Pays reconnu pour son hospitalité

**À découvrir :**

- Route des Pêches
- Ouidah (Route des Esclaves, Porte du Non-Retour, Temple des Pythons)
- Palais royaux d'Abomey (UNESCO)
- Ganvié, la cité lacustre
- Plages de Cotonou
- Place de l'Amazone
- Mur du graffiti du Port

---

## ℹ️ Informations pratiques

| | |
|---|---|
| **Monnaie** | Franc CFA (XOF) |
| **Climat** | Chaud et tropical |
| **Langue** | Français (anglais dans les hôtels) |
| **Transport** | Taxis & zémidjans |

---

## 💡 Tips pour un séjour réussi

- Prévoyez des vêtements légers en journée
- Optez pour des tenues élégantes en soirée
- Hydratez-vous régulièrement
- Découvrez la cuisine locale
- Profitez des excursions proposées
- Venez avec une bonne énergie ✨

---

## 🤝 L'esprit UKWC

Le UNITED KIZDOM WORLD CONGRESS, c'est bien plus qu'un événement :

- Une communauté internationale
- Des connexions humaines fortes
- Une immersion culturelle
- Une énergie unique

**Partage • Culture • Musique • Good vibes**

---

Nous avons hâte de vous accueillir à Cotonou du 14 au 19 juillet 2026.

Bienvenue dans la famille UKWC.

*L'équipe* **UNITED KIZDOM WORLD CONGRESS**

</x-mail::panel>

> Votre billet est également joint en pièce jointe. Présentez-le à l'entrée du festival. **Ne le partagez pas.**

En cas de problème, contactez-nous en indiquant la référence : **{{ $issuedTicket->uid }}**

À très bientôt sur la piste de danse !

**L'équipe {{ $festivalName }}**
</x-mail::message>
