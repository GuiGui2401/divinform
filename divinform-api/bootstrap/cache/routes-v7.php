<?php

app('router')->setCompiledRoutes(
    array (
  'compiled' => 
  array (
    0 => false,
    1 => 
    array (
      '/api/auth/login' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::1P5Vm1frgkBc0KQr',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/auth/logout' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::y7vLBmaYMqJ9inIk',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/auth/refresh' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::kAx7M3J0UetttO4i',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/auth/me' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::XHXjfPO03NrbCvbI',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/formations' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::zJZWIGTBnj8JKur9',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/inscriptions' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::cBirasqOhLUvMJIw',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/categories' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::EOSZtLVSO4zppYhd',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/products' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::nK4QDQ3Gnk3K1Bjg',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/settings' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::pW8SbcFf3dmKWFID',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/admin/stats' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::FNgsC1aUljcWqcD4',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/admin/formations' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'formations.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'formations.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/admin/formation-sessions' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'formation-sessions.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'formation-sessions.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/admin/inscriptions' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::2gQ8wVnauRLoJi9v',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/admin/categories' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'categories.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'categories.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/admin/products' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'products.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'products.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/admin/uploads' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::CP7yGhjMULBaFGza',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/admin/settings' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::mbe1ErvSy6AbbabA',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'generated::KB6lS6bSEZmE2cP2',
          ),
          1 => NULL,
          2 => 
          array (
            'PUT' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/admin/settings/upload' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::z7dQ4EKnYr1GTLFC',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/admin/users' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'users.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'users.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/admin/farm/dashboard' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::ewQcFA8b9q57eKHY',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/admin/farm/units' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'units.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'units.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/admin/farm/batches' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'batches.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'batches.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/admin/farm/animals' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'animals.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'animals.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/admin/farm/feed-items' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'feed-items.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'feed-items.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/admin/farm/feed-movements' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::FMw8LIIVTyyvZuSY',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'generated::FWGgCq6SaZ9IGAjp',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/admin/farm/health-events' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::8FxXbedbbRw8X45n',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'generated::6fDePmcR7smkwS6E',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/up' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::KzuMltGyv6ZG7d5y',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
    ),
    2 => 
    array (
      0 => '{^(?|/api/(?|v1/(?|formations/([^/]++)(?|(*:43)|/(?|view(*:58)|contact(*:72)))|categories/([^/]++)(*:100)|products/([^/]++)(?|(*:128)|/(?|view(*:144)|contact(*:159))))|admin/(?|f(?|ormation(?|s/([^/]++)(?|(*:207))|\\-sessions/([^/]++)(?|(*:238)))|arm/(?|units/([^/]++)(?|(*:272))|batches/([^/]++)(?|(*:300))|animals/([^/]++)(?|(*:328))|feed\\-(?|items/([^/]++)(?|(*:363))|movements/([^/]++)(*:390))|health\\-events/([^/]++)(*:422)))|inscriptions/([^/]++)(?|(*:456))|categories/([^/]++)(?|(*:487))|products/([^/]++)(?|(*:516)|/images(?|(*:534)|/([^/]++)(*:551)))|users/([^/]++)(?|(*:578)))))/?$}sDu',
    ),
    3 => 
    array (
      43 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::kdIfD91aTH8oEM3O',
          ),
          1 => 
          array (
            0 => 'slug',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      58 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::JzzAlOQZy27I4Z1J',
          ),
          1 => 
          array (
            0 => 'formation',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      72 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::Knhq6KP8QEuy1cq2',
          ),
          1 => 
          array (
            0 => 'formation',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      100 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::THc7afNgSPlNmb1Y',
          ),
          1 => 
          array (
            0 => 'slug',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      128 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::fSRhF6TWSvzdgkcV',
          ),
          1 => 
          array (
            0 => 'slug',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      144 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::po0CR9lnKPj82xBf',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      159 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::sZoBdlTH3Psi8dvx',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      207 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'formations.show',
          ),
          1 => 
          array (
            0 => 'formation',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'formations.update',
          ),
          1 => 
          array (
            0 => 'formation',
          ),
          2 => 
          array (
            'PUT' => 0,
            'PATCH' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        2 => 
        array (
          0 => 
          array (
            '_route' => 'formations.destroy',
          ),
          1 => 
          array (
            0 => 'formation',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      238 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'formation-sessions.update',
          ),
          1 => 
          array (
            0 => 'formation_session',
          ),
          2 => 
          array (
            'PUT' => 0,
            'PATCH' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'formation-sessions.destroy',
          ),
          1 => 
          array (
            0 => 'formation_session',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      272 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'units.update',
          ),
          1 => 
          array (
            0 => 'farmUnit',
          ),
          2 => 
          array (
            'PUT' => 0,
            'PATCH' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'units.destroy',
          ),
          1 => 
          array (
            0 => 'farmUnit',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      300 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'batches.show',
          ),
          1 => 
          array (
            0 => 'farmBatch',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'batches.update',
          ),
          1 => 
          array (
            0 => 'farmBatch',
          ),
          2 => 
          array (
            'PUT' => 0,
            'PATCH' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        2 => 
        array (
          0 => 
          array (
            '_route' => 'batches.destroy',
          ),
          1 => 
          array (
            0 => 'farmBatch',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      328 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'animals.update',
          ),
          1 => 
          array (
            0 => 'farmAnimal',
          ),
          2 => 
          array (
            'PUT' => 0,
            'PATCH' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'animals.destroy',
          ),
          1 => 
          array (
            0 => 'farmAnimal',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      363 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'feed-items.update',
          ),
          1 => 
          array (
            0 => 'feedItem',
          ),
          2 => 
          array (
            'PUT' => 0,
            'PATCH' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'feed-items.destroy',
          ),
          1 => 
          array (
            0 => 'feedItem',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      390 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::PlkyeqT46sMwiFAX',
          ),
          1 => 
          array (
            0 => 'feedMovement',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      422 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::5i17N5gDcOgvZSXg',
          ),
          1 => 
          array (
            0 => 'healthEvent',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      456 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::uHii2tOlxYH6QZJm',
          ),
          1 => 
          array (
            0 => 'inscription',
          ),
          2 => 
          array (
            'PUT' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'generated::Ey9HuEVqsZilnyBJ',
          ),
          1 => 
          array (
            0 => 'inscription',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      487 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'categories.show',
          ),
          1 => 
          array (
            0 => 'category',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'categories.update',
          ),
          1 => 
          array (
            0 => 'category',
          ),
          2 => 
          array (
            'PUT' => 0,
            'PATCH' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        2 => 
        array (
          0 => 
          array (
            '_route' => 'categories.destroy',
          ),
          1 => 
          array (
            0 => 'category',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      516 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'products.show',
          ),
          1 => 
          array (
            0 => 'product',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'products.update',
          ),
          1 => 
          array (
            0 => 'product',
          ),
          2 => 
          array (
            'PUT' => 0,
            'PATCH' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        2 => 
        array (
          0 => 
          array (
            '_route' => 'products.destroy',
          ),
          1 => 
          array (
            0 => 'product',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      534 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::CJ96ZcMYyvnqqoeD',
          ),
          1 => 
          array (
            0 => 'product',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      551 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::zpAW0v6yeJpgsFtn',
          ),
          1 => 
          array (
            0 => 'product',
            1 => 'index',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      578 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'users.show',
          ),
          1 => 
          array (
            0 => 'user',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'users.update',
          ),
          1 => 
          array (
            0 => 'user',
          ),
          2 => 
          array (
            'PUT' => 0,
            'PATCH' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        2 => 
        array (
          0 => 
          array (
            '_route' => 'users.destroy',
          ),
          1 => 
          array (
            0 => 'user',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        3 => 
        array (
          0 => NULL,
          1 => NULL,
          2 => NULL,
          3 => NULL,
          4 => false,
          5 => false,
          6 => 0,
        ),
      ),
    ),
    4 => NULL,
  ),
  'attributes' => 
  array (
    'generated::1P5Vm1frgkBc0KQr' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/auth/login',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
        ),
        'uses' => 'App\\Http\\Controllers\\Auth\\AuthController@login',
        'controller' => 'App\\Http\\Controllers\\Auth\\AuthController@login',
        'namespace' => NULL,
        'prefix' => 'api/auth',
        'where' => 
        array (
        ),
        'as' => 'generated::1P5Vm1frgkBc0KQr',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::y7vLBmaYMqJ9inIk' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/auth/logout',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth.jwt',
        ),
        'uses' => 'App\\Http\\Controllers\\Auth\\AuthController@logout',
        'controller' => 'App\\Http\\Controllers\\Auth\\AuthController@logout',
        'namespace' => NULL,
        'prefix' => 'api/auth',
        'where' => 
        array (
        ),
        'as' => 'generated::y7vLBmaYMqJ9inIk',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::kAx7M3J0UetttO4i' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/auth/refresh',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth.jwt',
        ),
        'uses' => 'App\\Http\\Controllers\\Auth\\AuthController@refresh',
        'controller' => 'App\\Http\\Controllers\\Auth\\AuthController@refresh',
        'namespace' => NULL,
        'prefix' => 'api/auth',
        'where' => 
        array (
        ),
        'as' => 'generated::kAx7M3J0UetttO4i',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::XHXjfPO03NrbCvbI' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/auth/me',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth.jwt',
        ),
        'uses' => 'App\\Http\\Controllers\\Auth\\AuthController@me',
        'controller' => 'App\\Http\\Controllers\\Auth\\AuthController@me',
        'namespace' => NULL,
        'prefix' => 'api/auth',
        'where' => 
        array (
        ),
        'as' => 'generated::XHXjfPO03NrbCvbI',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::zJZWIGTBnj8JKur9' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/formations',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
        ),
        'uses' => 'App\\Http\\Controllers\\Public\\FormationController@index',
        'controller' => 'App\\Http\\Controllers\\Public\\FormationController@index',
        'namespace' => NULL,
        'prefix' => 'api/v1',
        'where' => 
        array (
        ),
        'as' => 'generated::zJZWIGTBnj8JKur9',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::kdIfD91aTH8oEM3O' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/formations/{slug}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
        ),
        'uses' => 'App\\Http\\Controllers\\Public\\FormationController@show',
        'controller' => 'App\\Http\\Controllers\\Public\\FormationController@show',
        'namespace' => NULL,
        'prefix' => 'api/v1',
        'where' => 
        array (
        ),
        'as' => 'generated::kdIfD91aTH8oEM3O',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::JzzAlOQZy27I4Z1J' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/v1/formations/{formation}/view',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
        ),
        'uses' => 'App\\Http\\Controllers\\Public\\FormationController@trackView',
        'controller' => 'App\\Http\\Controllers\\Public\\FormationController@trackView',
        'namespace' => NULL,
        'prefix' => 'api/v1',
        'where' => 
        array (
        ),
        'as' => 'generated::JzzAlOQZy27I4Z1J',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::Knhq6KP8QEuy1cq2' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/v1/formations/{formation}/contact',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
        ),
        'uses' => 'App\\Http\\Controllers\\Public\\FormationController@trackContact',
        'controller' => 'App\\Http\\Controllers\\Public\\FormationController@trackContact',
        'namespace' => NULL,
        'prefix' => 'api/v1',
        'where' => 
        array (
        ),
        'as' => 'generated::Knhq6KP8QEuy1cq2',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::cBirasqOhLUvMJIw' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/v1/inscriptions',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'throttle:5,10',
        ),
        'uses' => 'App\\Http\\Controllers\\Public\\InscriptionController@store',
        'controller' => 'App\\Http\\Controllers\\Public\\InscriptionController@store',
        'namespace' => NULL,
        'prefix' => 'api/v1',
        'where' => 
        array (
        ),
        'as' => 'generated::cBirasqOhLUvMJIw',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::EOSZtLVSO4zppYhd' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/categories',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
        ),
        'uses' => 'App\\Http\\Controllers\\Public\\CategoryController@index',
        'controller' => 'App\\Http\\Controllers\\Public\\CategoryController@index',
        'namespace' => NULL,
        'prefix' => 'api/v1',
        'where' => 
        array (
        ),
        'as' => 'generated::EOSZtLVSO4zppYhd',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::THc7afNgSPlNmb1Y' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/categories/{slug}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
        ),
        'uses' => 'App\\Http\\Controllers\\Public\\CategoryController@show',
        'controller' => 'App\\Http\\Controllers\\Public\\CategoryController@show',
        'namespace' => NULL,
        'prefix' => 'api/v1',
        'where' => 
        array (
        ),
        'as' => 'generated::THc7afNgSPlNmb1Y',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::nK4QDQ3Gnk3K1Bjg' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/products',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
        ),
        'uses' => 'App\\Http\\Controllers\\Public\\ProductController@index',
        'controller' => 'App\\Http\\Controllers\\Public\\ProductController@index',
        'namespace' => NULL,
        'prefix' => 'api/v1',
        'where' => 
        array (
        ),
        'as' => 'generated::nK4QDQ3Gnk3K1Bjg',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::fSRhF6TWSvzdgkcV' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/products/{slug}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
        ),
        'uses' => 'App\\Http\\Controllers\\Public\\ProductController@show',
        'controller' => 'App\\Http\\Controllers\\Public\\ProductController@show',
        'namespace' => NULL,
        'prefix' => 'api/v1',
        'where' => 
        array (
        ),
        'as' => 'generated::fSRhF6TWSvzdgkcV',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::po0CR9lnKPj82xBf' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/v1/products/{id}/view',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
        ),
        'uses' => 'App\\Http\\Controllers\\Public\\ProductController@trackView',
        'controller' => 'App\\Http\\Controllers\\Public\\ProductController@trackView',
        'namespace' => NULL,
        'prefix' => 'api/v1',
        'where' => 
        array (
        ),
        'as' => 'generated::po0CR9lnKPj82xBf',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::sZoBdlTH3Psi8dvx' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/v1/products/{id}/contact',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
        ),
        'uses' => 'App\\Http\\Controllers\\Public\\ProductController@trackContact',
        'controller' => 'App\\Http\\Controllers\\Public\\ProductController@trackContact',
        'namespace' => NULL,
        'prefix' => 'api/v1',
        'where' => 
        array (
        ),
        'as' => 'generated::sZoBdlTH3Psi8dvx',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::pW8SbcFf3dmKWFID' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/settings',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
        ),
        'uses' => 'App\\Http\\Controllers\\Public\\SettingController@index',
        'controller' => 'App\\Http\\Controllers\\Public\\SettingController@index',
        'namespace' => NULL,
        'prefix' => 'api/v1',
        'where' => 
        array (
        ),
        'as' => 'generated::pW8SbcFf3dmKWFID',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::FNgsC1aUljcWqcD4' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/admin/stats',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth.jwt',
          2 => 'role:super_admin,editor',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\AdminStatsController@index',
        'controller' => 'App\\Http\\Controllers\\Admin\\AdminStatsController@index',
        'namespace' => NULL,
        'prefix' => 'api/admin',
        'where' => 
        array (
        ),
        'as' => 'generated::FNgsC1aUljcWqcD4',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'formations.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/admin/formations',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth.jwt',
          2 => 'role:super_admin,editor',
        ),
        'as' => 'formations.index',
        'uses' => 'App\\Http\\Controllers\\Admin\\AdminFormationController@index',
        'controller' => 'App\\Http\\Controllers\\Admin\\AdminFormationController@index',
        'namespace' => NULL,
        'prefix' => 'api/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'formations.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/admin/formations',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth.jwt',
          2 => 'role:super_admin,editor',
        ),
        'as' => 'formations.store',
        'uses' => 'App\\Http\\Controllers\\Admin\\AdminFormationController@store',
        'controller' => 'App\\Http\\Controllers\\Admin\\AdminFormationController@store',
        'namespace' => NULL,
        'prefix' => 'api/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'formations.show' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/admin/formations/{formation}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth.jwt',
          2 => 'role:super_admin,editor',
        ),
        'as' => 'formations.show',
        'uses' => 'App\\Http\\Controllers\\Admin\\AdminFormationController@show',
        'controller' => 'App\\Http\\Controllers\\Admin\\AdminFormationController@show',
        'namespace' => NULL,
        'prefix' => 'api/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'formations.update' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
        1 => 'PATCH',
      ),
      'uri' => 'api/admin/formations/{formation}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth.jwt',
          2 => 'role:super_admin,editor',
        ),
        'as' => 'formations.update',
        'uses' => 'App\\Http\\Controllers\\Admin\\AdminFormationController@update',
        'controller' => 'App\\Http\\Controllers\\Admin\\AdminFormationController@update',
        'namespace' => NULL,
        'prefix' => 'api/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'formations.destroy' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'api/admin/formations/{formation}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth.jwt',
          2 => 'role:super_admin,editor',
        ),
        'as' => 'formations.destroy',
        'uses' => 'App\\Http\\Controllers\\Admin\\AdminFormationController@destroy',
        'controller' => 'App\\Http\\Controllers\\Admin\\AdminFormationController@destroy',
        'namespace' => NULL,
        'prefix' => 'api/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'formation-sessions.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/admin/formation-sessions',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth.jwt',
          2 => 'role:super_admin,editor',
        ),
        'as' => 'formation-sessions.index',
        'uses' => 'App\\Http\\Controllers\\Admin\\AdminFormationSessionController@index',
        'controller' => 'App\\Http\\Controllers\\Admin\\AdminFormationSessionController@index',
        'namespace' => NULL,
        'prefix' => 'api/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'formation-sessions.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/admin/formation-sessions',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth.jwt',
          2 => 'role:super_admin,editor',
        ),
        'as' => 'formation-sessions.store',
        'uses' => 'App\\Http\\Controllers\\Admin\\AdminFormationSessionController@store',
        'controller' => 'App\\Http\\Controllers\\Admin\\AdminFormationSessionController@store',
        'namespace' => NULL,
        'prefix' => 'api/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'formation-sessions.update' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
        1 => 'PATCH',
      ),
      'uri' => 'api/admin/formation-sessions/{formation_session}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth.jwt',
          2 => 'role:super_admin,editor',
        ),
        'as' => 'formation-sessions.update',
        'uses' => 'App\\Http\\Controllers\\Admin\\AdminFormationSessionController@update',
        'controller' => 'App\\Http\\Controllers\\Admin\\AdminFormationSessionController@update',
        'namespace' => NULL,
        'prefix' => 'api/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'formation-sessions.destroy' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'api/admin/formation-sessions/{formation_session}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth.jwt',
          2 => 'role:super_admin,editor',
        ),
        'as' => 'formation-sessions.destroy',
        'uses' => 'App\\Http\\Controllers\\Admin\\AdminFormationSessionController@destroy',
        'controller' => 'App\\Http\\Controllers\\Admin\\AdminFormationSessionController@destroy',
        'namespace' => NULL,
        'prefix' => 'api/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::2gQ8wVnauRLoJi9v' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/admin/inscriptions',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth.jwt',
          2 => 'role:super_admin,editor',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\AdminInscriptionController@index',
        'controller' => 'App\\Http\\Controllers\\Admin\\AdminInscriptionController@index',
        'namespace' => NULL,
        'prefix' => 'api/admin',
        'where' => 
        array (
        ),
        'as' => 'generated::2gQ8wVnauRLoJi9v',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::uHii2tOlxYH6QZJm' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
      ),
      'uri' => 'api/admin/inscriptions/{inscription}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth.jwt',
          2 => 'role:super_admin,editor',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\AdminInscriptionController@update',
        'controller' => 'App\\Http\\Controllers\\Admin\\AdminInscriptionController@update',
        'namespace' => NULL,
        'prefix' => 'api/admin',
        'where' => 
        array (
        ),
        'as' => 'generated::uHii2tOlxYH6QZJm',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::Ey9HuEVqsZilnyBJ' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'api/admin/inscriptions/{inscription}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth.jwt',
          2 => 'role:super_admin,editor',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\AdminInscriptionController@destroy',
        'controller' => 'App\\Http\\Controllers\\Admin\\AdminInscriptionController@destroy',
        'namespace' => NULL,
        'prefix' => 'api/admin',
        'where' => 
        array (
        ),
        'as' => 'generated::Ey9HuEVqsZilnyBJ',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'categories.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/admin/categories',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth.jwt',
          2 => 'role:super_admin,editor',
        ),
        'as' => 'categories.index',
        'uses' => 'App\\Http\\Controllers\\Admin\\AdminCategoryController@index',
        'controller' => 'App\\Http\\Controllers\\Admin\\AdminCategoryController@index',
        'namespace' => NULL,
        'prefix' => 'api/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'categories.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/admin/categories',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth.jwt',
          2 => 'role:super_admin,editor',
        ),
        'as' => 'categories.store',
        'uses' => 'App\\Http\\Controllers\\Admin\\AdminCategoryController@store',
        'controller' => 'App\\Http\\Controllers\\Admin\\AdminCategoryController@store',
        'namespace' => NULL,
        'prefix' => 'api/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'categories.show' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/admin/categories/{category}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth.jwt',
          2 => 'role:super_admin,editor',
        ),
        'as' => 'categories.show',
        'uses' => 'App\\Http\\Controllers\\Admin\\AdminCategoryController@show',
        'controller' => 'App\\Http\\Controllers\\Admin\\AdminCategoryController@show',
        'namespace' => NULL,
        'prefix' => 'api/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'categories.update' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
        1 => 'PATCH',
      ),
      'uri' => 'api/admin/categories/{category}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth.jwt',
          2 => 'role:super_admin,editor',
        ),
        'as' => 'categories.update',
        'uses' => 'App\\Http\\Controllers\\Admin\\AdminCategoryController@update',
        'controller' => 'App\\Http\\Controllers\\Admin\\AdminCategoryController@update',
        'namespace' => NULL,
        'prefix' => 'api/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'categories.destroy' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'api/admin/categories/{category}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth.jwt',
          2 => 'role:super_admin,editor',
        ),
        'as' => 'categories.destroy',
        'uses' => 'App\\Http\\Controllers\\Admin\\AdminCategoryController@destroy',
        'controller' => 'App\\Http\\Controllers\\Admin\\AdminCategoryController@destroy',
        'namespace' => NULL,
        'prefix' => 'api/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'products.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/admin/products',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth.jwt',
          2 => 'role:super_admin,editor',
        ),
        'as' => 'products.index',
        'uses' => 'App\\Http\\Controllers\\Admin\\AdminProductController@index',
        'controller' => 'App\\Http\\Controllers\\Admin\\AdminProductController@index',
        'namespace' => NULL,
        'prefix' => 'api/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'products.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/admin/products',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth.jwt',
          2 => 'role:super_admin,editor',
        ),
        'as' => 'products.store',
        'uses' => 'App\\Http\\Controllers\\Admin\\AdminProductController@store',
        'controller' => 'App\\Http\\Controllers\\Admin\\AdminProductController@store',
        'namespace' => NULL,
        'prefix' => 'api/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'products.show' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/admin/products/{product}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth.jwt',
          2 => 'role:super_admin,editor',
        ),
        'as' => 'products.show',
        'uses' => 'App\\Http\\Controllers\\Admin\\AdminProductController@show',
        'controller' => 'App\\Http\\Controllers\\Admin\\AdminProductController@show',
        'namespace' => NULL,
        'prefix' => 'api/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'products.update' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
        1 => 'PATCH',
      ),
      'uri' => 'api/admin/products/{product}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth.jwt',
          2 => 'role:super_admin,editor',
        ),
        'as' => 'products.update',
        'uses' => 'App\\Http\\Controllers\\Admin\\AdminProductController@update',
        'controller' => 'App\\Http\\Controllers\\Admin\\AdminProductController@update',
        'namespace' => NULL,
        'prefix' => 'api/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'products.destroy' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'api/admin/products/{product}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth.jwt',
          2 => 'role:super_admin,editor',
        ),
        'as' => 'products.destroy',
        'uses' => 'App\\Http\\Controllers\\Admin\\AdminProductController@destroy',
        'controller' => 'App\\Http\\Controllers\\Admin\\AdminProductController@destroy',
        'namespace' => NULL,
        'prefix' => 'api/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::CJ96ZcMYyvnqqoeD' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/admin/products/{product}/images',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth.jwt',
          2 => 'role:super_admin,editor',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\AdminProductController@uploadImages',
        'controller' => 'App\\Http\\Controllers\\Admin\\AdminProductController@uploadImages',
        'namespace' => NULL,
        'prefix' => 'api/admin',
        'where' => 
        array (
        ),
        'as' => 'generated::CJ96ZcMYyvnqqoeD',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::zpAW0v6yeJpgsFtn' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'api/admin/products/{product}/images/{index}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth.jwt',
          2 => 'role:super_admin,editor',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\AdminProductController@deleteImage',
        'controller' => 'App\\Http\\Controllers\\Admin\\AdminProductController@deleteImage',
        'namespace' => NULL,
        'prefix' => 'api/admin',
        'where' => 
        array (
        ),
        'as' => 'generated::zpAW0v6yeJpgsFtn',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::CP7yGhjMULBaFGza' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/admin/uploads',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth.jwt',
          2 => 'role:super_admin,editor',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\MediaController@upload',
        'controller' => 'App\\Http\\Controllers\\Admin\\MediaController@upload',
        'namespace' => NULL,
        'prefix' => 'api/admin',
        'where' => 
        array (
        ),
        'as' => 'generated::CP7yGhjMULBaFGza',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::mbe1ErvSy6AbbabA' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/admin/settings',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth.jwt',
          2 => 'role:super_admin,editor',
          3 => 'role:super_admin',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\AdminSettingController@index',
        'controller' => 'App\\Http\\Controllers\\Admin\\AdminSettingController@index',
        'namespace' => NULL,
        'prefix' => 'api/admin',
        'where' => 
        array (
        ),
        'as' => 'generated::mbe1ErvSy6AbbabA',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::KB6lS6bSEZmE2cP2' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
      ),
      'uri' => 'api/admin/settings',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth.jwt',
          2 => 'role:super_admin,editor',
          3 => 'role:super_admin',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\AdminSettingController@update',
        'controller' => 'App\\Http\\Controllers\\Admin\\AdminSettingController@update',
        'namespace' => NULL,
        'prefix' => 'api/admin',
        'where' => 
        array (
        ),
        'as' => 'generated::KB6lS6bSEZmE2cP2',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::z7dQ4EKnYr1GTLFC' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/admin/settings/upload',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth.jwt',
          2 => 'role:super_admin,editor',
          3 => 'role:super_admin',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\AdminSettingController@upload',
        'controller' => 'App\\Http\\Controllers\\Admin\\AdminSettingController@upload',
        'namespace' => NULL,
        'prefix' => 'api/admin',
        'where' => 
        array (
        ),
        'as' => 'generated::z7dQ4EKnYr1GTLFC',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'users.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/admin/users',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth.jwt',
          2 => 'role:super_admin,editor',
          3 => 'role:super_admin',
        ),
        'as' => 'users.index',
        'uses' => 'App\\Http\\Controllers\\Admin\\AdminUserController@index',
        'controller' => 'App\\Http\\Controllers\\Admin\\AdminUserController@index',
        'namespace' => NULL,
        'prefix' => 'api/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'users.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/admin/users',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth.jwt',
          2 => 'role:super_admin,editor',
          3 => 'role:super_admin',
        ),
        'as' => 'users.store',
        'uses' => 'App\\Http\\Controllers\\Admin\\AdminUserController@store',
        'controller' => 'App\\Http\\Controllers\\Admin\\AdminUserController@store',
        'namespace' => NULL,
        'prefix' => 'api/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'users.show' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/admin/users/{user}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth.jwt',
          2 => 'role:super_admin,editor',
          3 => 'role:super_admin',
        ),
        'as' => 'users.show',
        'uses' => 'App\\Http\\Controllers\\Admin\\AdminUserController@show',
        'controller' => 'App\\Http\\Controllers\\Admin\\AdminUserController@show',
        'namespace' => NULL,
        'prefix' => 'api/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'users.update' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
        1 => 'PATCH',
      ),
      'uri' => 'api/admin/users/{user}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth.jwt',
          2 => 'role:super_admin,editor',
          3 => 'role:super_admin',
        ),
        'as' => 'users.update',
        'uses' => 'App\\Http\\Controllers\\Admin\\AdminUserController@update',
        'controller' => 'App\\Http\\Controllers\\Admin\\AdminUserController@update',
        'namespace' => NULL,
        'prefix' => 'api/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'users.destroy' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'api/admin/users/{user}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth.jwt',
          2 => 'role:super_admin,editor',
          3 => 'role:super_admin',
        ),
        'as' => 'users.destroy',
        'uses' => 'App\\Http\\Controllers\\Admin\\AdminUserController@destroy',
        'controller' => 'App\\Http\\Controllers\\Admin\\AdminUserController@destroy',
        'namespace' => NULL,
        'prefix' => 'api/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::ewQcFA8b9q57eKHY' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/admin/farm/dashboard',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth.jwt',
          2 => 'role:super_admin,farm_manager',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\Farm\\FarmDashboardController@index',
        'controller' => 'App\\Http\\Controllers\\Admin\\Farm\\FarmDashboardController@index',
        'namespace' => NULL,
        'prefix' => 'api/admin/farm',
        'where' => 
        array (
        ),
        'as' => 'generated::ewQcFA8b9q57eKHY',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'units.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/admin/farm/units',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth.jwt',
          2 => 'role:super_admin,farm_manager',
        ),
        'as' => 'units.index',
        'uses' => 'App\\Http\\Controllers\\Admin\\Farm\\FarmUnitController@index',
        'controller' => 'App\\Http\\Controllers\\Admin\\Farm\\FarmUnitController@index',
        'namespace' => NULL,
        'prefix' => 'api/admin/farm',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'units.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/admin/farm/units',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth.jwt',
          2 => 'role:super_admin,farm_manager',
        ),
        'as' => 'units.store',
        'uses' => 'App\\Http\\Controllers\\Admin\\Farm\\FarmUnitController@store',
        'controller' => 'App\\Http\\Controllers\\Admin\\Farm\\FarmUnitController@store',
        'namespace' => NULL,
        'prefix' => 'api/admin/farm',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'units.update' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
        1 => 'PATCH',
      ),
      'uri' => 'api/admin/farm/units/{farmUnit}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth.jwt',
          2 => 'role:super_admin,farm_manager',
        ),
        'as' => 'units.update',
        'uses' => 'App\\Http\\Controllers\\Admin\\Farm\\FarmUnitController@update',
        'controller' => 'App\\Http\\Controllers\\Admin\\Farm\\FarmUnitController@update',
        'namespace' => NULL,
        'prefix' => 'api/admin/farm',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'units.destroy' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'api/admin/farm/units/{farmUnit}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth.jwt',
          2 => 'role:super_admin,farm_manager',
        ),
        'as' => 'units.destroy',
        'uses' => 'App\\Http\\Controllers\\Admin\\Farm\\FarmUnitController@destroy',
        'controller' => 'App\\Http\\Controllers\\Admin\\Farm\\FarmUnitController@destroy',
        'namespace' => NULL,
        'prefix' => 'api/admin/farm',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'batches.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/admin/farm/batches',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth.jwt',
          2 => 'role:super_admin,farm_manager',
        ),
        'as' => 'batches.index',
        'uses' => 'App\\Http\\Controllers\\Admin\\Farm\\FarmBatchController@index',
        'controller' => 'App\\Http\\Controllers\\Admin\\Farm\\FarmBatchController@index',
        'namespace' => NULL,
        'prefix' => 'api/admin/farm',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'batches.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/admin/farm/batches',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth.jwt',
          2 => 'role:super_admin,farm_manager',
        ),
        'as' => 'batches.store',
        'uses' => 'App\\Http\\Controllers\\Admin\\Farm\\FarmBatchController@store',
        'controller' => 'App\\Http\\Controllers\\Admin\\Farm\\FarmBatchController@store',
        'namespace' => NULL,
        'prefix' => 'api/admin/farm',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'batches.show' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/admin/farm/batches/{farmBatch}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth.jwt',
          2 => 'role:super_admin,farm_manager',
        ),
        'as' => 'batches.show',
        'uses' => 'App\\Http\\Controllers\\Admin\\Farm\\FarmBatchController@show',
        'controller' => 'App\\Http\\Controllers\\Admin\\Farm\\FarmBatchController@show',
        'namespace' => NULL,
        'prefix' => 'api/admin/farm',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'batches.update' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
        1 => 'PATCH',
      ),
      'uri' => 'api/admin/farm/batches/{farmBatch}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth.jwt',
          2 => 'role:super_admin,farm_manager',
        ),
        'as' => 'batches.update',
        'uses' => 'App\\Http\\Controllers\\Admin\\Farm\\FarmBatchController@update',
        'controller' => 'App\\Http\\Controllers\\Admin\\Farm\\FarmBatchController@update',
        'namespace' => NULL,
        'prefix' => 'api/admin/farm',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'batches.destroy' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'api/admin/farm/batches/{farmBatch}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth.jwt',
          2 => 'role:super_admin,farm_manager',
        ),
        'as' => 'batches.destroy',
        'uses' => 'App\\Http\\Controllers\\Admin\\Farm\\FarmBatchController@destroy',
        'controller' => 'App\\Http\\Controllers\\Admin\\Farm\\FarmBatchController@destroy',
        'namespace' => NULL,
        'prefix' => 'api/admin/farm',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'animals.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/admin/farm/animals',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth.jwt',
          2 => 'role:super_admin,farm_manager',
        ),
        'as' => 'animals.index',
        'uses' => 'App\\Http\\Controllers\\Admin\\Farm\\FarmAnimalController@index',
        'controller' => 'App\\Http\\Controllers\\Admin\\Farm\\FarmAnimalController@index',
        'namespace' => NULL,
        'prefix' => 'api/admin/farm',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'animals.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/admin/farm/animals',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth.jwt',
          2 => 'role:super_admin,farm_manager',
        ),
        'as' => 'animals.store',
        'uses' => 'App\\Http\\Controllers\\Admin\\Farm\\FarmAnimalController@store',
        'controller' => 'App\\Http\\Controllers\\Admin\\Farm\\FarmAnimalController@store',
        'namespace' => NULL,
        'prefix' => 'api/admin/farm',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'animals.update' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
        1 => 'PATCH',
      ),
      'uri' => 'api/admin/farm/animals/{farmAnimal}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth.jwt',
          2 => 'role:super_admin,farm_manager',
        ),
        'as' => 'animals.update',
        'uses' => 'App\\Http\\Controllers\\Admin\\Farm\\FarmAnimalController@update',
        'controller' => 'App\\Http\\Controllers\\Admin\\Farm\\FarmAnimalController@update',
        'namespace' => NULL,
        'prefix' => 'api/admin/farm',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'animals.destroy' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'api/admin/farm/animals/{farmAnimal}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth.jwt',
          2 => 'role:super_admin,farm_manager',
        ),
        'as' => 'animals.destroy',
        'uses' => 'App\\Http\\Controllers\\Admin\\Farm\\FarmAnimalController@destroy',
        'controller' => 'App\\Http\\Controllers\\Admin\\Farm\\FarmAnimalController@destroy',
        'namespace' => NULL,
        'prefix' => 'api/admin/farm',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'feed-items.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/admin/farm/feed-items',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth.jwt',
          2 => 'role:super_admin,farm_manager',
        ),
        'as' => 'feed-items.index',
        'uses' => 'App\\Http\\Controllers\\Admin\\Farm\\FeedItemController@index',
        'controller' => 'App\\Http\\Controllers\\Admin\\Farm\\FeedItemController@index',
        'namespace' => NULL,
        'prefix' => 'api/admin/farm',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'feed-items.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/admin/farm/feed-items',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth.jwt',
          2 => 'role:super_admin,farm_manager',
        ),
        'as' => 'feed-items.store',
        'uses' => 'App\\Http\\Controllers\\Admin\\Farm\\FeedItemController@store',
        'controller' => 'App\\Http\\Controllers\\Admin\\Farm\\FeedItemController@store',
        'namespace' => NULL,
        'prefix' => 'api/admin/farm',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'feed-items.update' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
        1 => 'PATCH',
      ),
      'uri' => 'api/admin/farm/feed-items/{feedItem}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth.jwt',
          2 => 'role:super_admin,farm_manager',
        ),
        'as' => 'feed-items.update',
        'uses' => 'App\\Http\\Controllers\\Admin\\Farm\\FeedItemController@update',
        'controller' => 'App\\Http\\Controllers\\Admin\\Farm\\FeedItemController@update',
        'namespace' => NULL,
        'prefix' => 'api/admin/farm',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'feed-items.destroy' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'api/admin/farm/feed-items/{feedItem}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth.jwt',
          2 => 'role:super_admin,farm_manager',
        ),
        'as' => 'feed-items.destroy',
        'uses' => 'App\\Http\\Controllers\\Admin\\Farm\\FeedItemController@destroy',
        'controller' => 'App\\Http\\Controllers\\Admin\\Farm\\FeedItemController@destroy',
        'namespace' => NULL,
        'prefix' => 'api/admin/farm',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::FMw8LIIVTyyvZuSY' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/admin/farm/feed-movements',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth.jwt',
          2 => 'role:super_admin,farm_manager',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\Farm\\FeedMovementController@index',
        'controller' => 'App\\Http\\Controllers\\Admin\\Farm\\FeedMovementController@index',
        'namespace' => NULL,
        'prefix' => 'api/admin/farm',
        'where' => 
        array (
        ),
        'as' => 'generated::FMw8LIIVTyyvZuSY',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::FWGgCq6SaZ9IGAjp' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/admin/farm/feed-movements',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth.jwt',
          2 => 'role:super_admin,farm_manager',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\Farm\\FeedMovementController@store',
        'controller' => 'App\\Http\\Controllers\\Admin\\Farm\\FeedMovementController@store',
        'namespace' => NULL,
        'prefix' => 'api/admin/farm',
        'where' => 
        array (
        ),
        'as' => 'generated::FWGgCq6SaZ9IGAjp',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::PlkyeqT46sMwiFAX' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'api/admin/farm/feed-movements/{feedMovement}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth.jwt',
          2 => 'role:super_admin,farm_manager',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\Farm\\FeedMovementController@destroy',
        'controller' => 'App\\Http\\Controllers\\Admin\\Farm\\FeedMovementController@destroy',
        'namespace' => NULL,
        'prefix' => 'api/admin/farm',
        'where' => 
        array (
        ),
        'as' => 'generated::PlkyeqT46sMwiFAX',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::8FxXbedbbRw8X45n' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/admin/farm/health-events',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth.jwt',
          2 => 'role:super_admin,farm_manager',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\Farm\\HealthEventController@index',
        'controller' => 'App\\Http\\Controllers\\Admin\\Farm\\HealthEventController@index',
        'namespace' => NULL,
        'prefix' => 'api/admin/farm',
        'where' => 
        array (
        ),
        'as' => 'generated::8FxXbedbbRw8X45n',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::6fDePmcR7smkwS6E' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/admin/farm/health-events',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth.jwt',
          2 => 'role:super_admin,farm_manager',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\Farm\\HealthEventController@store',
        'controller' => 'App\\Http\\Controllers\\Admin\\Farm\\HealthEventController@store',
        'namespace' => NULL,
        'prefix' => 'api/admin/farm',
        'where' => 
        array (
        ),
        'as' => 'generated::6fDePmcR7smkwS6E',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::5i17N5gDcOgvZSXg' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'api/admin/farm/health-events/{healthEvent}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth.jwt',
          2 => 'role:super_admin,farm_manager',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\Farm\\HealthEventController@destroy',
        'controller' => 'App\\Http\\Controllers\\Admin\\Farm\\HealthEventController@destroy',
        'namespace' => NULL,
        'prefix' => 'api/admin/farm',
        'where' => 
        array (
        ),
        'as' => 'generated::5i17N5gDcOgvZSXg',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::KzuMltGyv6ZG7d5y' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'up',
      'action' => 
      array (
        'uses' => 'O:55:"Laravel\\SerializableClosure\\UnsignedSerializableClosure":1:{s:12:"serializable";O:46:"Laravel\\SerializableClosure\\Serializers\\Native":5:{s:3:"use";a:0:{}s:8:"function";s:853:"function () {
                    $exception = null;

                    try {
                        \\Illuminate\\Support\\Facades\\Event::dispatch(new \\Illuminate\\Foundation\\Events\\DiagnosingHealth);
                    } catch (\\Throwable $e) {
                        if (app()->hasDebugModeEnabled()) {
                            throw $e;
                        }

                        report($e);

                        $exception = $e->getMessage();
                    }

                    return response(\\Illuminate\\Support\\Facades\\View::file(\'/var/www/clients/client0/web105/web/divinform/divinform-api/vendor/laravel/framework/src/Illuminate/Foundation/Configuration\'.\'/../resources/health-up.blade.php\', [
                        \'exception\' => $exception,
                    ]), status: $exception ? 500 : 200);
                }";s:5:"scope";s:54:"Illuminate\\Foundation\\Configuration\\ApplicationBuilder";s:4:"this";N;s:4:"self";s:32:"00000000000006260000000000000000";}}',
        'as' => 'generated::KzuMltGyv6ZG7d5y',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
  ),
)
);
