
    @extends('layouts.web.main-layout')

@section('title', 'Link Building Marketplace & Outreach Automation Tool | GPSites')
@section('description', 'Find relevant guest posting sites, connect with publishers, and manage your outreach in one place. GPSites — the link building marketplace and outreach automation tool.')
@section('keywords', 'link building marketplace, guest posting sites, publisher outreach, outreach automation, backlink marketplace, GPSites')
@section('indexing', 'yes')

@section('content')

    <main class="gp-page gp-home">
        <section class="gp-section gp-hero">
            <div class="gp-container">
                <div class="gp-split">
                    <div><span class="gp-eyebrow">Publisher discovery & outreach</span>
                        <h1><span>Link Building</span><br>Marketplace &amp;<br>Outreach Automation Tool</h1>
                        <p>Find relevant guest posting sites, connect with publishers,<br> and manage your outreach in
                            one place.</p>
                        <div class="gp-actions"><a class="gp-button " href="https://gpsites.io/login">Start Free
                                Trial</a><a class="gp-button gp-outline" href="home.html#pricing">Compare
                                Plans</a><small class="gp-trial-note">7 days free · 3 email credits · No credit card
                                required</small></div>
                    </div>
                    <div><img class="gp-art" src="../public/gpsites/images/home-hero.webp" alt="" width="390"
                            height="249" loading="lazy"></div>
                </div>
            </div>
        </section>
        <section class="gp-section gp-tint gp-trust">
            <div class="gp-container">
                <div class="gp-grid gp-cols-3 ">
                    <article class="gp-card "><span class="gp-icon"><svg aria-hidden="true" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"
                                stroke-linejoin="round">
                                <circle cx="10" cy="10" r="7" />
                                <path d="m15 15 6 6" />
                            </svg></span>
                        <div>
                            <h3>Niche & metric filters</h3>
                            <p>Find the right publishers, faster.</p>
                        </div>
                    </article>
                    <article class="gp-card "><span class="gp-icon"><svg aria-hidden="true" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="m22 2-7 20-4-9-9-4 20-7ZM11 13 22 2" />
                            </svg></span>
                        <div>
                            <h3>Manual publisher outreach</h3>
                            <p>Send personalized, targeted offers.</p>
                        </div>
                    </article>
                    <article class="gp-card "><span class="gp-icon"><svg aria-hidden="true" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"
                                stroke-linejoin="round">
                                <circle cx="9" cy="7" r="3" />
                                <circle cx="18" cy="8" r="2" />
                                <path d="M2 21v-3a7 7 0 0 1 14 0v3H2ZM17 14q5 0 5 7h-4" />
                            </svg></span>
                        <div>
                            <h3>Unlimited team members</h3>
                            <p>Collaborate without limits.</p>
                        </div>
                    </article>
                </div>
            </div>
        </section>
        <section class="gp-section ">
            <div class="gp-container"><span class="gp-eyebrow">Publisher discovery</span>
                <h2>Find guest posting sites that fit your campaign</h2>
                <p>Search our database of publisher websites using niche and SEO metrics to find the best
                    opportunities<br>for your outreach campaign.</p>
                <form class="gp-publisher-search" action="https://gpsites.io/login" method="get">
                    <div class="gp-placement"><label><input type="radio" name="placement" value="guest-post" checked>
                            Guest posts</label><label><input type="radio" name="placement" value="link-insertion"> Link
                            insertions</label><label><input type="radio" name="placement" value="press-release"> Press
                            releases</label></div>
                    <div class="gp-filters"><label>Niche<select name="niche">
                                <option value="Technology">Technology</option>
                                <option value="Health & Wellness">Health & Wellness</option>
                                <option value="Business">Business</option>
                            </select></label><label>Domain Authority<select name="da">
                                <option value="30">Min 30</option>
                                <option value="50">Min 50</option>
                                <option value="70">Min 70</option>
                            </select></label><label>Domain Rating<select name="dr">
                                <option value="30">Min 30</option>
                                <option value="50">Min 50</option>
                                <option value="70">Min 70</option>
                            </select></label><label>Traffic<select name="traffic">
                                <option value="">Any</option>
                                <option value="10000">10000</option>
                                <option value="100000">100000</option>
                            </select></label><button class="gp-button">Find Matching Sites</button></div>
                </form>
                <div class="gp-table-panel">
                    <div class="gp-between"><b>Example results</b><small>3 results shown (illustrative data)</small>
                    </div>
                    <div class="gp-scroll">
                        <table>
                            <thead>
                                <tr>
                                    <th>Domain</th>
                                    <th>Niche</th>
                                    <th>DA</th>
                                    <th>DR</th>
                                    <th>Traffic</th>
                                    <th>Placement type</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="gp-purple">technology.example</td>
                                    <td>Technology</td>
                                    <td>67</td>
                                    <td>62</td>
                                    <td>125K</td>
                                    <td><span class="gp-pill">Guest post</span></td>
                                    <td><a class="gp-link" href="https://gpsites.io/login">View details →</a></td>
                                </tr>
                                <tr>
                                    <td class="gp-purple">wellness.example</td>
                                    <td>Health & Wellness</td>
                                    <td>54</td>
                                    <td>48</td>
                                    <td>89K</td>
                                    <td><span class="gp-pill">Link insertion</span></td>
                                    <td><a class="gp-link" href="https://gpsites.io/login">View details →</a></td>
                                </tr>
                                <tr>
                                    <td class="gp-purple">business.example</td>
                                    <td>Business</td>
                                    <td>61</td>
                                    <td>55</td>
                                    <td>112K</td>
                                    <td><span class="gp-pill">Guest post</span></td>
                                    <td><a class="gp-link" href="https://gpsites.io/login">View details →</a></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>
        <section class="gp-section " id="how-it-works">
            <div class="gp-container"><span class="gp-eyebrow">How it works</span>
                <h2>From publisher discovery to your next conversation</h2>
                <div class="gp-grid gp-cols-4 ">
                    <article class="gp-card gp-step"><span class="gp-icon"><svg aria-hidden="true" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"
                                stroke-linejoin="round">
                                <circle cx="10" cy="10" r="7" />
                                <path d="m15 15 6 6" />
                            </svg></span>
                        <div>
                            <h3><b class="gp-purple">01</b><br>Find your sites</h3>
                            <p>Search by niche and SEO metrics to find relevant publishers.</p>
                        </div>
                    </article>
                    <article class="gp-card gp-step"><span class="gp-icon"><svg aria-hidden="true" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="M14 2H5v20h14V7l-5-5Z M14 2v6h5 M8 12h8 M8 16h6" />
                            </svg></span>
                        <div>
                            <h3><b class="gp-purple">02</b><br>Choose your approach</h3>
                            <p>Send custom offers or place direct orders (Agency).</p>
                        </div>
                    </article>
                    <article class="gp-card gp-step"><span class="gp-icon"><svg aria-hidden="true" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="m22 2-7 20-4-9-9-4 20-7ZM11 13 22 2" />
                            </svg></span>
                        <div>
                            <h3><b class="gp-purple">03</b><br>Launch outreach</h3>
                            <p>Reach out to publishers and automate follow-ups.</p>
                        </div>
                    </article>
                    <article class="gp-card gp-step"><span class="gp-icon"><svg aria-hidden="true" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="M3 21h19 M6 17V9h3v8 M12 17V5h3v12 M18 17V2h3v15" />
                            </svg></span>
                        <div>
                            <h3><b class="gp-purple">04</b><br>Manage next steps</h3>
                            <p>Track conversations, offers and orders in one place.</p>
                        </div>
                    </article>
                </div>
            </div>
        </section>
        <section class="gp-section gp-tint" id="features">
            <div class="gp-container"><span class="gp-eyebrow">Features</span>
                <h2>Less repetitive work. More focused outreach.</h2>
                <div class="gp-grid gp-cols-3 ">
                    <article class="gp-card gp-horizontal"><span class="gp-icon"><svg aria-hidden="true"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"
                                stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="10" cy="10" r="7" />
                                <path d="m15 15 6 6" />
                            </svg></span>
                        <div>
                            <h3>Target relevant publishers</h3>
                            <p>Search by niche and metrics to find the best opportunities.</p>
                        </div>
                    </article>
                    <article class="gp-card gp-horizontal"><span class="gp-icon"><svg aria-hidden="true"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"
                                stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="5" width="18" height="14" rx="2" />
                                <path d="m3 6 9 7 9-7" />
                            </svg></span>
                        <div>
                            <h3>Send custom offers</h3>
                            <p>Reach out with personalized offers on every plan.</p>
                        </div>
                    </article>
                    <article class="gp-card gp-horizontal"><span class="gp-icon"><svg aria-hidden="true"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path d="m9 2-1 3-3 1-3 4 2 2-1 4 3 3 3-1 3 4 4-1 1-3 4-2-1-4 2-3-3-3-4 1-2-3Z" />
                                <circle cx="12" cy="12" r="3" />
                            </svg></span>
                        <div>
                            <h3>Automate follow-ups</h3>
                            <p>Save time with automated follow-up sequences.</p>
                        </div>
                    </article>
                    <article class="gp-card gp-horizontal"><span class="gp-icon"><svg aria-hidden="true"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path d="M8 5h14M8 12h14M8 19h14M2 5h1M2 12h1M2 19h1" />
                            </svg></span>
                        <div>
                            <h3>Manage offers & orders</h3>
                            <p>Keep track of all your conversations, offers and orders.</p>
                        </div>
                    </article>
                    <article class="gp-card gp-horizontal"><span class="gp-icon"><svg aria-hidden="true"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path d="M3 3h9l9 9-9 9-9-9V3Z" />
                                <circle cx="8" cy="8" r="1" />
                            </svg></span>
                        <div>
                            <h3>View negotiated prices</h3>
                            <p>Agency members can see publisher prices and place direct orders.</p>
                        </div>
                    </article>
                    <article class="gp-card gp-horizontal"><span class="gp-icon"><svg aria-hidden="true"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path d="M3 21h19 M6 17V9h3v8 M12 17V5h3v12 M18 17V2h3v15" />
                            </svg></span>
                        <div>
                            <h3>Review site insights</h3>
                            <p>Check key metrics and placement options before you reach out.</p>
                        </div>
                    </article>
                </div>
            </div>
        </section>
        <section class="gp-section gp-dark">
            <div class="gp-container">
                <div class="gp-split">
                    <div><span class="gp-eyebrow">Pricing flexibility</span>
                        <h2>Your offer. Or a negotiated price.</h2>
                        <p>Send custom offers on every plan. Agency members can also view negotiated publisher prices
                            and place direct orders.</p><a class="gp-button gp-white" href="home.html#pricing">Explore
                            Agency</a>
                    </div>
                    <div class="gp-offers">
                        <div class="gp-offer"><span class="gp-icon"><svg aria-hidden="true" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <rect x="3" y="5" width="18" height="14" rx="2" />
                                    <path d="m3 6 9 7 9-7" />
                                </svg></span>
                            <h3>Custom offer</h3>
                            <p>Send a personalized offer to the publisher.</p><label>Your offer (USD)<input readonly
                                    value="$250"></label><small>Illustrative preview</small><a class="gp-button "
                                href="https://gpsites.io/login">Send offer</a>
                        </div>
                        <div class="gp-offer"><span class="gp-icon"><svg aria-hidden="true" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <rect x="3" y="5" width="18" height="14" rx="2" />
                                    <path d="m3 6 9 7 9-7" />
                                </svg></span>
                            <h3>Direct order</h3>
                            <p>View negotiated publisher prices and place a direct order.</p><label>Publisher
                                price<input readonly value="$425"></label><small>Illustrative preview</small><a
                                class="gp-button " href="https://gpsites.io/login">Place direct order</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="gp-section ">
            <div class="gp-container"><span class="gp-eyebrow">Built for your team</span>
                <h2>Built for the way your team works</h2>
                <div class="gp-grid gp-cols-3 gp-audiences">
                    <article class="gp-card gp-horizontal"><span class="gp-icon"><svg aria-hidden="true"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"
                                stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="9" cy="7" r="3" />
                                <circle cx="18" cy="8" r="2" />
                                <path d="M2 21v-3a7 7 0 0 1 14 0v3H2ZM17 14q5 0 5 7h-4" />
                            </svg></span>
                        <div>
                            <h3>SEO agencies</h3>
                            <p>Organize outreach for multiple clients and manage campaigns in one place.</p>
                        </div>
                    </article>
                    <article class="gp-card gp-horizontal"><span class="gp-icon"><svg aria-hidden="true"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path
                                    d="m2 7 10-5 10 5 M4 8v14h16V8 M8 10v2m4-2v2m4-2v2M8 15v2m4-2v2m4 0v-2M10 22v-3h4v3" />
                            </svg></span>
                        <div>
                            <h3>In-house marketing teams</h3>
                            <p>Find relevant publishers and keep outreach organized across campaigns.</p>
                        </div>
                    </article>
                    <article class="gp-card gp-horizontal"><span class="gp-icon"><svg aria-hidden="true"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"
                                stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="9" cy="7" r="3" />
                                <circle cx="18" cy="8" r="2" />
                                <path d="M2 21v-3a7 7 0 0 1 14 0v3H2ZM17 14q5 0 5 7h-4" />
                            </svg></span>
                        <div>
                            <h3>Independent marketers</h3>
                            <p>Discover opportunities and manage outreach without the manual work.</p>
                        </div>
                    </article>
                </div>
            </div>
        </section>
        <section class="gp-section " id="pricing">
            <div class="gp-container"><span class="gp-eyebrow">Pricing</span>
                <h2>Choose the outreach plan that fits your workload</h2>
                <div class="gp-grid gp-cols-3 ">
                    <article class="gp-price ">
                        <h3>Starter</h3>
                        <div class="gp-price-value">$198<small> / month</small></div>
                        <ul>
                            <li>20K active blogs</li>
                            <li>100 emails per day</li>
                            <li>Custom outreach</li>
                            <li>Unlimited team members</li>
                        </ul><a class="gp-button gp-soft" href="https://gpsites.io/login">Choose Starter</a>
                    </article>
                    <article class="gp-price ">
                        <h3>Pro</h3>
                        <div class="gp-price-value">$449<small> / month</small></div>
                        <ul>
                            <li>40K active blogs</li>
                            <li>250 emails per day</li>
                            <li>Bulk email campaigns</li>
                            <li>Unlimited team members</li>
                        </ul><a class="gp-button gp-soft" href="https://gpsites.io/login">Choose Pro</a>
                    </article>
                    <article class="gp-price gp-featured"><span class="gp-ribbon">Most popular</span>
                        <h3>Agency</h3>
                        <div class="gp-price-value">$1,199<small> / month</small></div>
                        <ul>
                            <li>Full available blog collection</li>
                            <li>1,000 emails per day</li>
                            <li>Negotiated prices & direct orders</li>
                            <li>Live chat support</li>
                        </ul><a class="gp-button " href="https://gpsites.io/login">Choose Agency</a>
                    </article>
                </div>
                <div class="gp-trial-bar"><span class="gp-icon"><svg aria-hidden="true" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M14 2H5v20h14V7l-5-5Z M14 2v6h5 M8 12h8 M8 16h6" />
                        </svg></span>
                    <div>
                        <h3>Try GPSites free for 7 days</h3><small>3 email credits · No credit card required</small>
                    </div><a class="gp-button " href="https://gpsites.io/login">Start Free Trial</a>
                </div>
            </div>
        </section>
        <section class="gp-section " id="faq">
            <div class="gp-container">
                <div class="gp-home-bottom">
                    <div><span class="gp-eyebrow">FAQ</span>
                        <h2>Questions before you get started?</h2>
                        <div class="gp-faq ">
                            <details open>
                                <summary>What is GPSites?</summary>
                                <div>A link building marketplace and outreach tool for finding publishers, sending
                                    offers and managing orders.</div>
                            </details>
                            <details>
                                <summary>How do offers and direct orders differ?</summary>
                                <div>Offers propose your terms. Agency members can place direct orders at negotiated
                                    prices.</div>
                            </details>
                            <details>
                                <summary>Which placement types are available?</summary>
                                <div>Guest posts, link insertions and press releases, depending on the publisher.</div>
                            </details>
                            <details>
                                <summary>Can my team use GPSites together?</summary>
                                <div>Yes. Subscription plans include unlimited team members.</div>
                            </details>
                            <details>
                                <summary>Does GPSites guarantee rankings?</summary>
                                <div>No. Rankings, indexing and AI search visibility are not guaranteed. Paid placements
                                    should use appropriate sponsored or nofollow links.</div>
                            </details>
                        </div>
                    </div>
                    <div class="gp-compact"><span class="gp-eyebrow">Contact</span>
                        <h2>Tell us about your outreach goals</h2>
                        <p>Have a question or want to learn more? Send us a message.</p><a class="gp-link"
                            href="mailto:info@leelija.com">info@leelija.com</a>
                        <form id="gp-inquiry" class="gp-form" data-inquiry data-connected="false" method="post"
                            action="">

                            <h2>Send us an inquiry</h2>
                            <p>Choose a topic and tell us how we can help. Fields marked * are required.</p>


                            <div class="gp-grid gp-cols-2"><label>Full name <span>*</span><input name="name"
                                        autocomplete="name" maxlength="120" value="" placeholder="Your name"
                                        required></label><label>Email address <span>*</span><input name="email"
                                        type="email" autocomplete="email" maxlength="254" value=""
                                        placeholder="Your email address" required></label></div>
                            <label class="gp-phone-field">Phone number — optional<input name="phone" type="tel"
                                    autocomplete="tel" maxlength="40" value=""
                                    placeholder="Include your country code"></label>
                            <label>Subject <span>*</span><select name="subject" required>
                                    <option value="">Select an inquiry type</option>
                                    <option>Plans and pricing</option>
                                    <option>Account or technical support</option>
                                    <option>Campaign or order inquiry</option>
                                    <option>Billing inquiry</option>
                                    <option>Publisher partnership</option>
                                    <option>Feedback or other inquiry</option>
                                </select></label>
                            <div class="gp-topics"><span>Plans and pricing</span><span>Account or technical
                                    support</span><span>Campaign or order inquiry</span><span>Billing
                                    inquiry</span><span>Publisher partnership</span><span>Feedback or other
                                    inquiry</span></div>
                            <label>Message <span>*</span><textarea name="message" rows="5" maxlength="10000"
                                    placeholder="Tell us what you need help with. Include a website URL or campaign or order reference, if applicable."
                                    required></textarea></label>
                            <p class="gp-form-help">Please do not include passwords, one-time codes or full payment card
                                details.<br>Read our <a href="">Privacy Policy</a> for information about how personal
                                data is handled.</p>
                            <button class="gp-button gp-submit" type="submit">Send Inquiry →</button>

                        </form>
                    </div>
                </div>
            </div>
        </section>
        <section class="gp-section gp-cta">
            <div class="gp-container">
                <h2>Find your next publisher with GPSites</h2>
                <p>Discover relevant sites, send your offer and manage the conversation in one place.</p>
                <div class="gp-actions"><a class="gp-button gp-white" href="https://gpsites.io/login">Start Free
                        Trial</a></div>
            </div>
        </section>
    </main>
@endsection

@section('scripts')
<script>
    // Smooth scroll for in-page anchor links (e.g. #pricing, #how-it-works, #features, #faq)
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('a[href^="#"]').forEach(function (link) {
            link.addEventListener('click', function (e) {
                const targetId = this.getAttribute('href');
                if (!targetId || targetId === '#') return;
                const target = document.querySelector(targetId);
                if (!target) return;

                e.preventDefault();
                const nav = document.querySelector('nav');
                const navHeight = nav ? nav.offsetHeight : 0;
                const offset = target.getBoundingClientRect().top + window.pageYOffset - navHeight - 12;

                window.scrollTo({ top: offset, behavior: 'smooth' });
            });
        });
    });
</script>
@endsection