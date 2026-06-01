<?php

namespace App\Helpers;

use App\Models\Inquiry;
use Carbon\Carbon;
use Illuminate\Support\Str;

class InquiryFormatter
{
    private static array $projectTypeMap = [
        'new_website'     => 'Nieuwe website',
        'redesign'        => 'Website vernieuwen',
        'webshop'         => 'Webshop / online verkoop',
        'contact_form'    => 'Contact- of offerteformulier',
        'seo_local'       => 'SEO / lokale vindbaarheid',
        'app_tool'        => 'App, tool of webapplicatie',
        'maintenance'     => 'Onderhoud / aanpassingen',
        'audit'           => 'Website audit / advies',
        'other'           => 'Iets anders',
        'web_application' => 'Webapplicatie (legacy)',
        'app_idea'        => 'App-idee (legacy)',
    ];

    private static array $needsMap = [
        'seo_visibility'          => 'Beter gevonden via Google',
        'seo_landing_pages'       => "SEO-landingpagina's",
        'custom_form'             => 'Formulier op maat',
        'products_online'         => 'Producten online tonen of verkopen',
        'multilingual'            => 'Meertaligheid',
        'post_launch_maintenance' => 'Onderhoud na lancering',
        'website_advice'          => 'Advies over huidige website',
        'ai_summary_support'      => 'AI-ondersteuning',
        'auto_followup'           => 'Automatische opvolging',
    ];

    private static array $adminNeedsMap = [
        'static'     => 'Vaste website, geen beheer',
        'basic_edit' => "Zelf teksten/foto's aanpassen",
        'admin'      => 'Eenvoudige adminomgeving',
        'not_sure'   => 'Nog niet zeker',
    ];

    private static array $budgetMap = [
        'not_sure'   => 'Nog niet zeker',
        '750_1250'   => '€750 – €1.250',
        '1250_2500'  => '€1.250 – €2.500',
        '2500_5000'  => '€2.500 – €5.000',
        '5000_plus'  => '€5.000+',
    ];

    private static array $timelineMap = [
        'no_rush'           => 'Geen haast',
        'within_1_month'    => 'Binnen 1 maand',
        'within_2_3_months' => 'Binnen 2–3 maanden',
        'asap'              => 'Zo snel mogelijk',
        'not_sure'          => 'Nog niet zeker',
    ];

    public static function toRows(Inquiry $inquiry): array
    {
        $rows = [];

        // Meta
        $rows[] = ['label' => '#Aanvraag',     'value' => $inquiry->id ? '#' . $inquiry->id : '—'];
        $rows[] = ['label' => 'Ontvangen',     'value' => $inquiry->created_at ? Carbon::parse($inquiry->created_at)->format('d/m/Y H:i') : '—'];
        $rows[] = ['label' => 'Formuliertaal', 'value' => $inquiry->locale ?? '—'];

        // Contact
        $rows[] = ['label' => 'Naam',     'value' => $inquiry->name     ?: '—'];
        $rows[] = ['label' => 'E-mail',   'value' => $inquiry->email    ?: '—'];
        $rows[] = ['label' => 'Telefoon', 'value' => $inquiry->phone    ?: '—'];
        $rows[] = ['label' => 'Bedrijf',  'value' => $inquiry->company_name ?: '—'];

        // Project
        $rows[] = [
            'label' => 'Projecttype',
            'value' => self::$projectTypeMap[$inquiry->project_type] ?? ($inquiry->project_type ?: '—'),
        ];
        $rows[] = ['label' => 'Bestaande website', 'value' => $inquiry->existing_website_url ?: '—'];

        // Multilingual needs (stored as JSON array via cast)
        $multiRaw = $inquiry->multilingual_needs;
        $multi    = is_array($multiRaw) ? $multiRaw
            : (is_string($multiRaw) ? (json_decode($multiRaw, true) ?? [$multiRaw]) : []);
        $rows[] = ['label' => 'Meertaligheid', 'value' => $multi ? implode(', ', $multi) : '—'];

        if ($inquiry->other_language) {
            $rows[] = ['label' => 'Andere taal', 'value' => $inquiry->other_language];
        }

        $rows[] = [
            'label' => 'Contentbeheer',
            'value' => self::$adminNeedsMap[$inquiry->content_admin_needs] ?? ($inquiry->content_admin_needs ?: '—'),
        ];

        // Extra needs (JSON array of string keys)
        $needsRaw = $inquiry->needs;
        $needs    = is_array($needsRaw) ? $needsRaw
            : (is_string($needsRaw) ? (json_decode($needsRaw, true) ?? []) : []);
        $needsLabels = array_map(
            fn($k) => self::$needsMap[$k] ?? Str::title(str_replace('_', ' ', $k)),
            $needs
        );
        $rows[] = ['label' => 'Extra behoeften', 'value' => $needsLabels ? implode(', ', $needsLabels) : '—'];

        $rows[] = ['label' => 'Projectomschrijving', 'value' => $inquiry->project_description ?: '—', 'pre_wrap' => true];

        $rows[] = [
            'label' => 'Budget',
            'value' => self::$budgetMap[$inquiry->budget_range] ?? ($inquiry->budget_range ?: '—'),
        ];
        $rows[] = [
            'label' => 'Gewenste timing',
            'value' => self::$timelineMap[$inquiry->timeline] ?? ($inquiry->timeline ?: '—'),
        ];

        // Consent & tracking
        $rows[] = ['label' => 'Privacyverklaring', 'value' => $inquiry->gdpr_consent ? 'Ja' : 'Nee'];
        $rows[] = ['label' => 'Aanvraagbron',      'value' => $inquiry->source   ?: '—'];
        $rows[] = ['label' => 'IP-hash',           'value' => $inquiry->ip_hash  ?: '—'];

        // Unknown/future fields — nothing dropped
        $knownKeys = [
            'id', 'created_at', 'updated_at', 'locale',
            'name', 'email', 'phone', 'company_name',
            'project_type', 'existing_website_url',
            'multilingual_needs', 'other_language', 'content_admin_needs', 'needs',
            'project_description', 'budget_range', 'timeline',
            'gdpr_consent', 'source', 'ip_hash', 'user_agent',
        ];

        $unknownFields = array_diff_key($inquiry->toArray(), array_flip($knownKeys));
        foreach ($unknownFields as $key => $value) {
            $rows[] = [
                'label' => Str::title(str_replace('_', ' ', $key)),
                'value' => self::formatUnknownValue($value),
            ];
        }

        return $rows;
    }

    private static function formatUnknownValue(mixed $value): string
    {
        if (is_null($value))                       return '—';
        if (is_bool($value))                       return $value ? 'Ja' : 'Nee';
        if (is_string($value) && $value === '')    return '—';
        if (is_array($value)) {
            $parts = array_map([self::class, 'formatUnknownValue'], $value);
            return implode(', ', $parts) ?: '—';
        }
        if (is_object($value)) {
            return method_exists($value, '__toString') ? (string) $value : get_class($value);
        }
        return (string) $value;
    }
}
