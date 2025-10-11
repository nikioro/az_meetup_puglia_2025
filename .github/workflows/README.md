# GitHub Actions Workflow Configuration

## Configurazione Secrets e Variables

Per utilizzare questo workflow, è necessario configurare i seguenti secrets e variables nel repository GitHub.

### Secrets (Settings → Secrets and variables → Actions → Secrets)

| Nome | Descrizione | Esempio |
|------|-------------|---------|
| `AZURE_CREDENTIALS` | Credenziali Azure per l'autenticazione | JSON con clientId, clientSecret, subscriptionId, tenantId |
| `DB_PASSWORD` | Password del database MySQL | `mySecretPassword123!` |

### Variables (Settings → Secrets and variables → Actions → Variables)

| Nome | Descrizione | Esempio |
|------|-------------|---------|
| `AZURE_APP_SERVICE_NAME` | Nome dell'App Service Azure | `my-php-app` |
| `AZURE_DEPLOYMENT_SLOT` | Slot di deployment (opzionale) | `staging` o `production` |
| `DB_HOST` | Host del database MySQL | `myserver.mysql.database.azure.com` |
| `DB_USERNAME` | Username del database | `adminuser@myserver` |
| `DB_DATABASE` | Nome del database | `mydatabase` |

### Environment Configuration

Il workflow supporta due environment:
- **staging**: Per deploy automatici dal branch main
- **production**: Per deploy manuali tramite workflow_dispatch

Per configurare gli environments:
1. Vai su Settings → Environments
2. Crea gli environments `staging` e `production`
3. Configura le protection rules se necessario

## Configurazione Azure Credentials

Per ottenere le credenziali Azure:

```bash
az ad sp create-for-rbac --name "github-actions-sp" --role contributor --scopes /subscriptions/{subscription-id}/resourceGroups/{resource-group} --sdk-auth
```

Il comando restituirà un JSON da inserire nel secret `AZURE_CREDENTIALS`:

```json
{
  "clientId": "...",
  "clientSecret": "...",
  "subscriptionId": "...",
  "tenantId": "..."
}
```

## Utilizzo del Workflow

### Deploy Automatico
Il workflow si attiva automaticamente su:
- Push al branch `main` (deploy su staging)
- Pull request al branch `main` (solo build e test)

### Deploy Manuale
1. Vai su Actions → Deploy to Azure App Service Linux
2. Clicca su "Run workflow"
3. Seleziona l'environment (staging/production)
4. Clicca su "Run workflow"

## Funzionalità del Workflow

- ✅ **Build PHP**: Setup PHP 8.2 con estensioni necessarie
- ✅ **Dependency Management**: Gestione automatica dipendenze Composer
- ✅ **Code Validation**: Controllo sintassi PHP
- ✅ **Artifact Creation**: Creazione package ottimizzato per production
- ✅ **Azure Deployment**: Deploy su App Service Linux
- ✅ **Environment Configuration**: Configurazione automatica variabili ambiente
- ✅ **Health Check**: Verifica post-deployment con retry automatico
- ✅ **Multi-Environment**: Support per staging e production
- ✅ **Deployment Slots**: Supporto per Azure deployment slots

## Personalizzazione

### Modificare la versione PHP
Cambia la variabile `PHP_VERSION` nel workflow:

```yaml
env:
  PHP_VERSION: '8.1'  # o altra versione supportata
```

### Aggiungere nuove variabili di ambiente
Aggiungi nuove variabili nella sezione `app-settings-json`:

```yaml
{
  "name": "MY_CUSTOM_VAR",
  "value": "${{ vars.MY_CUSTOM_VAR }}",
  "slotSetting": false
}
```

### Personalizzare il health check
Modifica l'URL o i criteri di verifica nella sezione health-check del workflow.