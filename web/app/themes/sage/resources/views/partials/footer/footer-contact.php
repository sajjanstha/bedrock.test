<!-- Modal -->
<div
    id="modal-contact"
    class="modal fade bd-example-modal-xl modal-contact"
    tabindex="-1"
    role="dialog"
    aria-hidden="true"
>
    <div
        class="modal-dialog modal-dialog-centered modal-xl mr-auto ml-auto"
        role="document"
    >
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title text-uppercase">
                    Get in touch
                </h3>
                <button
                    type="button"
                    class="close"
                    data-dismiss="modal"
                    aria-label="Close"
                    id="contactModalClose"
                >
                    <svg
                        viewPort="0 0 12 12"
                        version="1.1"
                        xmlns="http://www.w3.org/2000/svg"
                    >
                        <line
                            x1="1"
                            y1="30"
                            x2="30"
                            y2="1"
                            stroke="black"
                            stroke-width="2"
                        />
                        <line
                            x1="1"
                            y1="1"
                            x2="30"
                            y2="30"
                            stroke="black"
                            stroke-width="2"
                        />
                    </svg>
                </button>
            </div>
            <div class="modal-body">

                <div class="d-flex flex-column flex-lg-row ">
<!--                    <form id="contact-form" class="contact-form">-->
                        <?php echo do_shortcode('[contact-form-7 id="98" title="Contact form popup"]'); ?>
<!--                    </form>-->
                    <div
                        class="contact-message mt-5 mt-lg-0"
                    >
                        <!-- <h4 class="mb-5 text-uppercase text-bold">Come and see us!</h4> -->
                        <h4 class="mb-5 text-uppercase">
                            VNY Secretariat Office
                        </h4>
                        <label for="" class="small text-dark d-block"
                        >Visit Nepal 2020 Secretariat</label
                        >

                        <h5 class="mb-5">
                            Kaiser Mahal, Kathmandu 44600
                        </h5>
                        <!-- <h5 class="mb-5">
                                Corner Morning Lane + Chatham Place
                                London, E9 6LL
                        </h5> -->
                        <label for="" class="small text-dark d-block"
                        >Email</label
                        >

                        <h5 class="mb-5">
                            <a href="mailto:noreply@2020.com"
                            >info@nepal2020.org.np</a
                            >
                        </h5>
                        <label for="" class="small text-dark d-block"
                        >Phone</label
                        >

                        <h5 class="mb-5">
                            +977-1-4425035
                        </h5>
                    </div>
                </div>
                <h4 class="d-none" id="success-message">
                    Thank you for reaching out. We will be in touch with you
                    shortly.
                </h4>
            </div>
        </div>
    </div>
</div>
