<?php
Use factories: User::factory(50)->create()->each(function ($user) { $user->update(['role' => 'client']); Loan::factory(3)->create(['client_id' => $user->id]); });
