# Veterinario — Sistema di monitoraggio clinico per animali

Progetto ancora in fase di approvazione — Università di Parma

Applicazione web PHP/MySQL per il monitoraggio remoto dei sintomi gastrointestinali degli animali domestici. I proprietari registrano i sintomi giornalieri, i veterinari consultano lo storico tramite grafici interattivi.

---

## Funzionalità

### Ruolo: Proprietario
- Registrazione account (collegato al veterinario di riferimento)
- Inserimento log giornaliero con 10 parametri clinici (vomito, appetito, atteggiamento, dimagrimento, frequenza feci, sangue, muco, flatulenza, lambimento, data)
- Gestione dei propri animali (inserimento scheda con razza, peso, sesso, terapie/dieta/diagnosi iniziale T0)

### Ruolo: Veterinario
- Dashboard con lista dei pazienti assegnati
- Visualizzazione info generali del paziente (scheda T0)
- Storico sintomi con grafici a linee (Chart.js), filtrabili per intervallo di date

---

## Stack tecnologico

| Layer      | Tecnologia                     |
|------------|-------------------------------|
| Backend    | PHP 8.4                        |
| Database   | MariaDB 11.8 (MySQL-compatibile) |
| Frontend   | Bootstrap 5.3, Bootstrap Icons |
| Grafici    | Chart.js                       |
| Auth       | Session PHP + bcrypt (password_hash) |

---

## Struttura del progetto

```
veterinario/
├── index.php              # Landing page (login / registrati)
├── login.php              # Form di login
├── logout.php             # Distruzione sessione
├── choose_signin_type.php # Scelta tipo account
├── signin_customer.php    # Registrazione proprietario
├── signin_vet.php         # Registrazione veterinario
├── dashboard_owner.php    # Dashboard proprietario
├── dashboard_vet.php      # Dashboard veterinario
├── insert_animale.php     # Inserimento nuovo animale
├── insert_log.php         # Inserimento log giornaliero
├── storico.php            # Grafici storico sintomi
├── info_animale.php       # Scheda info animale
├── connection/
│   ├── connection.php     # Helper connessione DB
│   ├── check_owner.php    # Guard sessione proprietario
│   ├── check_vet.php      # Guard sessione veterinario
│   └── veterinario.sql    # Dump DB con dati di esempio
└── veterinario.sql        # Dump DB (root)
```

---

## Installazione

### Requisiti
- PHP >= 8.0
- MariaDB / MySQL
- Web server (Apache/Nginx) con `mod_rewrite`

### Setup

1. **Clona il repository**
   ```bash
   git clone <repo-url>
   cd veterinario
   ```

2. **Importa il database**
   ```bash
   mysql -u root -p < connection/veterinario.sql
   ```

3. **Configura la connessione** in `connection/connection.php`:
   ```php
   // Modifica host, user, password, database secondo il tuo ambiente
   ```

4. **Punta il web server** sulla cartella del progetto (es. `/var/www/html/veterinario` o `htdocs/veterinario`)

5. **Apri nel browser**: `http://localhost/veterinario/`

---

## Credenziali di esempio (dal dump SQL)

| Tipo        | Username   | Password                |
|-------------|------------|------------------------|
| Veterinario | `dr_rossi` | `monolitico` |
| Proprietario | `luca85`  | `monolitico` |

> I dati di esempio sono solo per scopo dimostrativo.

---

## Schema del database

Le tabelle principali sono:

- **`pazienti`** — anagrafica animali (nome, razza, peso, sesso, T0)
- **`proprietari`** — account proprietari
- **`veterinari`** — account veterinari
- **`pazienti_veterinari`** — relazione N:M paziente–veterinario
- **`log`** — rilevazioni giornaliere con FK verso 9 tabelle di lookup

Tabelle di lookup (valori + peso numerico per la visualizzazione grafica):
`vomito`, `appetito`, `atteggiamento`, `dimagrimento`, `frequenza_feci`, `sangue`, `muco`, `flatulenza`, `lambimento`

---

## Autore

Progetto sviluppato per il corso universitario — Università di Parma, A.A. 2025/2026.
