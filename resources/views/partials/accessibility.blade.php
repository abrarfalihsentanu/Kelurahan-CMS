<div class="a11y-widget" id="a11yWidget">
    <button class="a11y-toggle" id="a11yToggle" aria-label="{{ __('ui.a11y_open') }}" title="{{ __('ui.a11y_title') }}">
        <i class="fa fa-universal-access"></i>
    </button>
    <div class="a11y-panel" id="a11yPanel" role="dialog" aria-labelledby="a11yTitle" aria-hidden="true">
        <div class="a11y-panel-header">
            <h3 id="a11yTitle"><i class="fa fa-universal-access"></i> {{ __('ui.a11y_title') }}</h3>
            <button class="a11y-close" id="a11yClose" aria-label="{{ __('ui.a11y_close') }}"><i
                    class="fa fa-times"></i></button>
        </div>
        <div class="a11y-lang">
            <i class="fa fa-globe"></i> {{ __('ui.a11y_lang') }}
        </div>
        <div class="a11y-grid">
            <button class="a11y-btn" data-action="speech" aria-pressed="false">
                <div class="a11y-icon"><i class="fa fa-volume-up"></i></div>
                <span>{{ __('ui.a11y_speech') }}</span>
            </button>
            <button class="a11y-btn" data-action="font-increase" aria-pressed="false">
                <div class="a11y-icon"><span style="font-size:18px;font-weight:700;">T</span><span
                        style="font-size:24px;font-weight:700;">T</span></div>
                <span>{{ __('ui.a11y_font_increase') }}</span>
            </button>
            <button class="a11y-btn" data-action="font-decrease" aria-pressed="false">
                <div class="a11y-icon"><span style="font-size:24px;font-weight:700;">T</span><span
                        style="font-size:18px;font-weight:700;">T</span></div>
                <span>{{ __('ui.a11y_font_decrease') }}</span>
            </button>
            <button class="a11y-btn" data-action="grayscale" aria-pressed="false">
                <div class="a11y-icon"><i class="fa fa-tint"></i></div>
                <span>{{ __('ui.a11y_grayscale') }}</span>
            </button>
            <button class="a11y-btn" data-action="contrast" aria-pressed="false">
                <div class="a11y-icon"><i class="fa fa-adjust"></i></div>
                <span>{{ __('ui.a11y_contrast') }}</span>
            </button>
            <button class="a11y-btn" data-action="hide-images" aria-pressed="false">
                <div class="a11y-icon"><i class="fa fa-image"></i><i class="fa fa-ban"
                        style="position:absolute;font-size:28px;opacity:.7;"></i></div>
                <span>{{ __('ui.a11y_hide_images') }}</span>
            </button>
            <button class="a11y-btn" data-action="text-align" aria-pressed="false">
                <div class="a11y-icon"><i class="fa fa-align-justify"></i></div>
                <span>{{ __('ui.a11y_text_align') }}</span>
            </button>
            <button class="a11y-btn" data-action="dyslexia" aria-pressed="false">
                <div class="a11y-icon"><span
                        style="font-size:28px;font-weight:700;font-family:'OpenDyslexic',sans-serif;">A</span></div>
                <span>{{ __('ui.a11y_dyslexia') }}</span>
            </button>
            <button class="a11y-btn" data-action="line-height" aria-pressed="false">
                <div class="a11y-icon"><i class="fa fa-text-height"></i></div>
                <span>{{ __('ui.a11y_line_height') }}</span>
            </button>
            <button class="a11y-btn" data-action="pause-animation" aria-pressed="false">
                <div class="a11y-icon"><i class="fa fa-hourglass-half"></i></div>
                <span>{{ __('ui.a11y_pause_animation') }}</span>
            </button>
            <button class="a11y-btn" data-action="big-cursor" aria-pressed="false">
                <div class="a11y-icon"><i class="fa fa-mouse-pointer"></i></div>
                <span>{{ __('ui.a11y_big_cursor') }}</span>
            </button>
            <button class="a11y-btn" data-action="letter-spacing" aria-pressed="false">
                <div class="a11y-icon"><span style="font-size:18px;font-weight:700;letter-spacing:6px;">T T</span></div>
                <span>{{ __('ui.a11y_letter_spacing') }}</span>
            </button>
            <button class="a11y-btn" data-action="underline-links" aria-pressed="false">
                <div class="a11y-icon"><i class="fa fa-underline"></i></div>
                <span>{{ __('ui.a11y_underline_links') }}</span>
            </button>
            <button class="a11y-btn a11y-reset" data-action="reset">
                <div class="a11y-icon"><i class="fa fa-undo"></i></div>
                <span>{{ __('ui.a11y_reset') }}</span>
            </button>
        </div>
    </div>
</div>
