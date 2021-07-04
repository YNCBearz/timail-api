# Command

--- 

### Make Migration (create)
```zsh
php artisan make:migration CreateRequestExecutionTable
```

### Make Migration (update)
```zsh
php artisan make:migration AddStatusCodeToRequestExecutionTable --table=request_executions
```

---


### Refresh Database (for develop)
```zsh
php artisan migrate:fresh --seed
```

### Rollback Migration
```zsh
php artisan migrate:rollback
```
