<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        Builder::macro('toSqlWithBindings', function () {
            $bindings = array_map(
                fn($value) => is_numeric($value) ? $value : "'{$value}'",
                $this->getBindings()
            );
            return Str::replaceArray('?', $bindings, $this->toSql());
        });

        Builder::macro('whereLike', function ($attribute, string $TermToSearch) {
            foreach (array_wrap($attribute) as $attribute) {
                $this->orWhere($attribute, 'LIKE', "%{$TermToSearch}%");
            }
            return $this;
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}