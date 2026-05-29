<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inquiry extends Model
{
    protected $fillable = [
        'name',
        'company_name',
        'email',
        'phone',
        'existing_website_url',
        'project_type',
        'timeline',
        'budget_range',
        'multilingual_needs',
        'other_language',
        'content_admin_needs',
        'needs',
        'project_description',
        'gdpr_consent',
        'source',
        'ip_hash',
        'user_agent',
    ];

    protected $casts = [
        'gdpr_consent'       => 'boolean',
        'multilingual_needs' => 'array',
        'needs'              => 'array',
    ];
}
