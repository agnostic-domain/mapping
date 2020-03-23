<h1 align="center">Agnostic Domain Mapping</h1>

<p align="center">
    <a href="https://github.com/daniel-iwaniec/agnostic-domain-mapping">
        <img src="https://i.imgur.com/0W5Ym0x.png" alt="Agnostic Domain Mapping" width="300" height="300">
    </a>
</p>

<p align="center">
    Simplify the hydration and extraction of agnostic domain objects
</p>

<p align="center">
    <a href="https://github.com/phpstan/phpstan">
        <img src="https://img.shields.io/badge/static_analysis-phpstan-success.svg" alt="Static analysis">
    </a>
    <a href="https://www.php-fig.org/psr/psr-2/">
        <img src="https://img.shields.io/badge/coding_style-psr--2-success.svg" alt="Coding standard">
    </a>
    <a href="https://choosealicense.com/licenses/mit/">
        <img src="https://img.shields.io/badge/license-mit-success.svg" alt="License">
    </a>
</p>

# Rationale

> Note that this is still largely experimental work in progress

<p align="justify">
According to DDD domain should be guarded against external constraints and let's say <i>agnostic</i>.
Most ORMs impose constraints in order to work properly
and even better ones aren't free from the object-relational impedance mismatch.
Assuming that you are ruling out event sourcing and other alternatives (for whatever reason)
and still want to use ORM while having clean domain you need to decouple them.
This decoupling comes with the cost of mapping between two layers.
The&nbsp;goal of this library isn't to eliminate this cost via magic
and another set of framework constraints, but rather to <b>minimize</b>.
</p>

# Key ideas

* Hydration and extraction is done via reflection.
  * Domain constructors should reflect creating a new model, not data from which it's restored.
* Objects can be mapped in many to many relation.
  * Domain shouldn't be coupled with database's tables.

# Installation

```bash
composer require daniel-iwaniec/agnostic-domain-mapping
```

# Getting started

### Mapping data object to domain object

```php
adm(Article::class)
    ->id($data->id)
    ->title($data->title)($data);
```

### Reverse mapping domain object to data object

```php
$data = adm()->data($article);
$data->title = adm($article)->title();
```

[Documentation](doc/documentation.md)
