<section class="lg:py-16 py-12 px-6">
  <div class="container mx-auto px-4">
    <!-- Title -->
    <h2 class="text-h2-xs sm:text-h2-sm md:text-h2-md lg:text-h2-lg lgg:text-h2-lgg xl:text-h2-xl 2xl:text-h2-2xl
               font-bold text-center text-gray-900 mb-10">
      Frequently asked questions
    </h2>

    <!-- FAQ List -->
    <div class="space-y-4">

      @foreach ($faqs as $faq)
        <div class="faq-wrapper bg-white rounded-lg shadow-sm border border-gray-200">
        <div class="flex justify-between items-center w-full text-left px-6 py-5 cursor-pointer">
          <span class="text-lg font-medium text-gray-900">{{ $faq['question'] }}</span>
          <svg class="faq-chevaron w-5 h-5 text-gray-500 transition-transform duration-300"
            fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M19 9l-7 7-7-7" />
          </svg>
        </div>
        <div class="line-border-block h-px bg-secondary opacity-[0.7] transition-all duration-300"></div>
        <div class="faq-content-block px-6 text-gray-600 text-base leading-relaxed overflow-hidden">
          <p>
            {!! $faq['answer'] !!}
          </p>
        </div>
      </div>
      @endforeach
    </div>
  </div>
</section>

<!-- JavaScript for Toggle -->
<script>
  document.addEventListener("DOMContentLoaded", function() {
    setTimeout(function() {
      const e = document.querySelectorAll(".faq-wrapper");
      let t;

      function o(e, t) {
        if (t) {
          const t = e.scrollHeight;
          (e.style.maxHeight = "0px"),
          (e.style.paddingTop = "0px"),
          (e.style.paddingBottom = "0px"),
          requestAnimationFrame(() => {
            (e.style.maxHeight = t + 32 + "px"),
            (e.style.paddingTop = "1rem"),
            (e.style.paddingBottom = "1rem");
          });
        } else(e.style.maxHeight = "0px"), (e.style.paddingTop = "0px"), (e.style.paddingBottom = "0px");
      }

      function n() {
        e.forEach((e) => {
          if (e.classList.contains("active")) {
            o(e.querySelector(".faq-content-block"), !0);
          }
        });
      }

      function i(t) {
        const n = t.querySelector(".flex.justify-between.items-center"),
          i = t.querySelector(".faq-content-block"),
          s = t.querySelector(".faq-chevaron"),
          r = t.querySelector(".line-border-block");
        n.addEventListener("click", function() {
          const n = t.classList.contains("active");
          var l;
          (l = t),
          e.forEach((e) => {
              if (e !== l && e.classList.contains("active")) {
                const t = e.querySelector(".faq-content-block"),
                  n = e.querySelector(".faq-chevaron"),
                  i = e.querySelector(".line-border-block");
                o(t, !1),
                  (t.style.opacity = "0"),
                  (i.style.width = "0"),
                  (n.style.transform = "rotate(90deg)"),
                  e.classList.remove("active");
              }
            }),
            n ?
            (o(i, !1),
              (i.style.opacity = "0"),
              (r.style.width = "0"),
              (s.style.transform = "rotate(90deg)"),
              t.classList.remove("active")) :
            ((i.style.opacity = "1"),
              (r.style.width = "100%"),
              (s.style.transform = "rotate(-90deg)"),
              t.classList.add("active"),
              o(i, !0),
              setTimeout(() => {
                o(i, !0);
              }, 50));
        });
      }
      e.forEach((e, t) => {
          const n = e.querySelector(".faq-content-block"),
            s = e.querySelector(".line-border-block");
          (n.style.transition =
            "max-height 0.4s ease, opacity 0.3s ease, padding-top 0.3s ease, padding-bottom 0.3s ease"),
          (n.style.overflow = "hidden"),
          (s.style.transition = "width 0.3s ease-in-out"),
          0 === t ?
            ((n.style.opacity = "1"),
              (n.style.paddingTop = "1rem"),
              (n.style.paddingBottom = "1rem"),
              (s.style.width = "100%"),
              (e.querySelector(".faq-chevaron").style.transform =
                "rotate(-90deg)"),
              e.classList.add("active"),
              o(n, !0),
              setTimeout(() => {
                o(n, !0);
              }, 50)) :
            (o(n, !1),
              (n.style.opacity = "0"),
              (n.style.paddingTop = "0px"),
              (n.style.paddingBottom = "0px"),
              (s.style.width = "0")),
            i(e);
        }),
        window.addEventListener("resize", function() {
          clearTimeout(t),
            (t = setTimeout(function() {
              n();
            }, 250));
        }),
        window.addEventListener("scroll", function() {
          clearTimeout(t),
            (t = setTimeout(function() {
              n();
            }, 100));
        }),
        setTimeout(() => {
          n();
        }, 50);
    }, 2e3);
  })
</script>