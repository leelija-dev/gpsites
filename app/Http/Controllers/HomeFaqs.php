<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeFaqs extends Controller
{
    public static function index()
    {
        $faqs = [ 
            ['question' => 'What is Link Building Outreach Automation Tool?',
            'answer' => 'Link building and outreach automation software is designed to automate the repetitive process of reaching out to external site owners, primarily for requesting backlinks. With this, you can reach out to multiple target prospects much faster, manage bulk outreach campaigns way more effectively, and secure the best link-building opportunities through guest posting on vetted sites.'],

            ['question' => 'What criteria can I use to filter and target prospects using this automation tool?',
            'answer' => 'With our outreach automation tools, you can filter your target prospects/bloggers/blogging sites based on multiple criteria, such as your niche industry, the language of the target country, the type of links you want (no-follow/do-follow), Domain Authority, Domain Rating, traffic, and your budget.'],

            ['question' => 'What level of personalization is possible with these AI-powered outreach tools?',
            'answer' => 'With AI-powered outreach & guest posting marketplace tools, you can easily personalize your pitches as they are highly efficient in crafting individualized outreach messages considering your target platform & the prospect’s specific needs. From generating unique subject lines to modifying the pitches according to personality profiles, these tools can scale up your manual outreach efforts significantly.'],

            ['question' => 'Does an automated outreach system detect spammy and low-quality websites?',
            'answer' => 'Yes! <br>These tools are built by integrating sophisticated technology, advanced Machine Learning features, and  the power of AI to actively identify and filter the potential spammy websites with low-quality content. With automated content analysis & authentication protocol systems, these systems can verify the identity of the target prospects and site content.'],

            ['question' => 'How many follow-up emails can be automated with the automation marketplace?',
            'answer' => 'It totally depends on the plan you pay for. <br>However, most outreach automation marketplace tools let you create follow-up emails with no limitation, as long as your monthly service plan contracts don’t expire. Still, to be on the safer side, always consult with the outreach experts before buying a plan.'],

            ['question' => 'Can I customize timing and content for outreach pitches using the automation toolkit?',
            'answer' => 'Absolutely! <br>With modern outreach automation systems, you can easily customize your pitching time and the outreach messages. In fact, these tools are designed to scale up your outreach efforts effectively and faster; not to replace the human touch with an automated one. Simply schedule the sequence, and you are good to go!'],

            ['question' => 'What performance metrics can I track using the link-building marketplace tools?',
            'answer' => 'Link-building marketplace tools effectively track multiple backlinks and website performance metrics, such as organic referral traffic, keyword rankings, link quality, Domain Authority, Domain Rating, & spam score of the resource platforms, anchor text diversity, Trust Flow, referral domains, link relevance & placements, conversion rates, ROI, & Cost Per Link.'],

            ['question' => 'Do you provide a full inventory of potential backlinks websites for my review before any outreach begins?',
            'answer' => 'Our outreach automation tool lets you preview the target websites, where you will learn about the brand, niche industry, services offered, and all the other relevant information, so that you can personalize your outreach pitches according to the specific needs of the prospects and industry demands.'],

            ['question' => 'Can I review and approve all content before it is pitched and published?',
            'answer' => 'Yes. <br>Automated outreach & link building marketplace tools use an AI-powered automated content approval workflow that lets you manually review and approve your outreach pitches in advance & ensure the essential human oversight required for effortless branding, quality control, and compliance with the specific requirements of the target prospects.'],

        ];
        return $faqs;
    }
} 
