# Correzioni PHPStan Livello 10 - Modulo User

Questo documento traccia gli errori PHPStan di livello 10 identificati nel modulo User e le relative soluzioni implementate.

## Errori Identificati e Correzioni Effettuate

### 1. Uso del tipo mixed in CheckOtpExpiredRule.php

```php
public function validate(string $attribute, mixed $value, \Closure $fail): void
```

**Problema**: Utilizzo del tipo `mixed` senza ulteriori specifiche sul tipo effettivo del valore. Inoltre, il metodo `message()` non aveva un tipo di ritorno esplicito.

**Soluzione**:
1. Aggiunta di documentazione PHPDoc per specificare che `$value` è un `string|int`:
   ```php
   /**
    * @param string $attribute L'attributo che viene validato
    * @param string|int $value Il valore dell'attributo
    * @param \Closure(string): void $fail La closure da chiamare in caso di fallimento
    */
   public function validate(string $attribute, mixed $value, \Closure $fail): void
   ```

2. Aggiunto tipo di ritorno esplicito per il metodo `message()`:
   ```php
   /**
    * @return string Il messaggio di errore
    */
   public function message(): string
   ```

### 2. Problemi di tipizzazione in ModelContract.php

**Problema**: Mancanza di annotazioni PHPDoc complete per i parametri e valori di ritorno dei metodi dell'interfaccia.

**Soluzione**:
1. Aggiunta di annotazioni PHPDoc complete per tutti i metodi:
   ```php
   /**
    * Fill the model with an array of attributes. Force mass assignment.
    *
    * @param array<string, mixed> $attributes Gli attributi da assegnare al modello
    * @return static Il modello stesso
    */
   public function forceFill(array $attributes);
   ```

2. Specificazione corretta dei tipi di array:
   ```php
   /**
    * Convert the model instance to an array.
    *
    * @return array<string, mixed> Il modello convertito in array
    */
   public function toArray();
   ```

3. Miglioramento della documentazione generale dell'interfaccia:
   ```php
   /**
    * Interfaccia ModelContract che deve essere implementata dai modelli.
    *
    * @phpstan-require-extends Model
    *
    * @mixin \Eloquent
    */
   interface ModelContract
   ```

### 3. Miglioramenti in PasswordData.php

**Problema**: Mancanza di annotazioni PHPDoc per metodi e proprietà, e utilizzo implicito di tipi mixed.

**Soluzione**:
1. Aggiunta di annotazioni PHPDoc complete per tutti i metodi:
   ```php
   /**
    * Crea un'istanza della classe PasswordData.
    *
    * @return self
    */
   public static function make(): self
   ```

2. Specificazione corretta dei tipi di array e parametri:
   ```php
   /**
    * Converte l'oggetto in un array.
    *
    * @return array<string, int|bool|string|null>
    */
   public function toArray(): array
   ```

3. Aggiunta di annotazioni di tipo per variabili locali:
   ```php
   /** @var array<string, mixed> $data */
   $data = TenantService::getConfig('password');
   ```

### 4. Correzioni in Filament/Pages/Password.php

**Problema**: Mancanza di annotazioni PHPDoc per metodi e proprietà, e utilizzo di tipi non specifici.

**Soluzione**:
1. Aggiunta di annotazioni PHPDoc complete per tutti i metodi e proprietà:
   ```php
   /**
    * Dati del form per la gestione delle password.
    *
    * @var array<string, mixed>|null
    */
   public ?array $formData = [];
   ```

2. Specificazione corretta dei tipi per parametri e valori di ritorno:
   ```php
   /**
    * Restituisce le azioni per il form di aggiornamento.
    *
    * @return array<Action>
    */
   protected function getUpdateFormActions(): array
   ```

3. Aggiunta di annotazioni di tipo per variabili locali:
   ```php
   /** @var array<string, mixed> $data */
   $data = $this->form->getState();
   ```

### 5. Miglioramenti in Http/Livewire/Auth/Login.php

**Problema**: Mancanza di annotazioni PHPDoc per metodi e proprietà, e utilizzo di tipi non specifici.

**Soluzione**:
1. Documentazione migliorata per la classe e le proprietà:
   ```php
   /**
    * Componente Livewire per la gestione del login.
    *
    * @property ComponentContainer $form
    */
   class Login extends Component implements HasForms
   ```

2. Specificazione corretta dei tipi per proprietà:
   ```php
   /**
    * Regole di validazione.
    *
    * @var array<string, array<string|object>>
    */
   protected $rules = [
       'email' => ['required', 'email'],
       'password' => ['required'],
       'remember' => ['boolean'],
   ];
   ```

3. Tipizzazione esplicita dei valori di ritorno e annotazioni per variabili:
   ```php
   /**
    * Esegue l'autenticazione dell'utente.
    *
    * @return RedirectResponse|void
    */
   public function authenticate()
   {
       /** @var array{email: string, password: string, remember?: bool} $data */
       $data = $this->validate();
   ```

## Principi Applicati

1. **Specificazione dei tipi**: Evitato l'uso del tipo `mixed` quando possibile, o almeno documentato i tipi effettivi attraverso PHPDoc.
2. **Tipi di array specificati**: Utilizzata la notazione generica per specificare i tipi di chiavi e valori degli array.
3. **Tipi di ritorno espliciti**: Aggiunti tipi di ritorno espliciti per tutti i metodi.
4. **Documentazione migliorata**: Aggiunta documentazione PHPDoc completa per classi, proprietà e metodi.
5. **Annotazioni per variabili locali**: Utilizzate le annotazioni `@var` per specificare i tipi delle variabili locali quando PHPStan non può inferirli correttamente.

## Considerazioni Future

1. Continua l'utilizzo di queste pratiche in tutto il modulo User e in altri moduli.
2. Considera l'uso di generics (come `@template`) per migliorare ulteriormente la tipizzazione delle classi che gestiscono diverse tipologie di dati.
3. Mantieni aggiornata la documentazione quando vengono modificati metodi o proprietà.
4. Utilizza strumenti di analisi automatica come PHPStan regolarmente per verificare che il codice rimanga conforme. 