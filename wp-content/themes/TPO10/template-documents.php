<?php /* Template Name: Documents Page Template */ get_header(); ?>

<main role="main">
    <!-- section -->
    <section>

        <h1><?php the_title(); ?></h1>
<?php get_sidebar(); ?>
        <?php if (have_posts()): while (have_posts()) : the_post(); ?>

            <!-- article -->
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

                <?php //the_content(); ?>
                <!-- BEGIN PAGE CONTENT-->
                <div class="row">
                <div class="col-md-6">

                    <!-- BEGIN SAMPLE TABLE PORTLET-->
                    <div class="portlet">
                        <div class="portlet-title">
                            <div class="caption"><i class="fa fa-shopping-cart"></i>SMSF Start &amp; Update</div>
                            <div class="tools"><a class="collapse">
                                </a>
                                <a class="config" href="#portlet-config" data-toggle="modal">
                                </a>
                                <a class="reload">
                                </a>
                                <a class="remove">
                                </a></div>
                        </div>
                        <div class="portlet-body">
                            <div class="table-scrollable">
                                <table class="table table-striped table-bordered table-advance table-hover">
                                    <thead>
                                    <tr>
                                        <th class="hidden-xs"><i class="fa "></i> Document</th>
                                        <th><i class="fa fa-bookmark"></i> Price</th>
                                        <th><i class="fa fa-bookmark"></i> Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td class="hidden-xs">SMSF Establishment</td>
                                        <td></td>
                                        <td><a class="btn default btn-xs green-stripe" href="/smsf-establishment">
                                                Create New </a></td>
                                    </tr>
                                    <tr>
                                        <td class="hidden-xs">SMSF Deed Update</td>
                                        <td></td>
                                        <td><a class="btn default btn-xs green-stripe" href="/smsfdeedupdate">
                                                Create New </a></td>
                                    </tr>
                                    <tr>
                                        <td class="hidden-xs">SMSF Change of Trustee</td>
                                        <td> <span class="label label-sm label-success label-mini">
1 saved </span></td>
                                        <td><a class="btn default btn-xs blue-stripe" href="#">
                                                Create New </a></td>
                                    </tr>
                                    <tr>
                                        <td class="hidden-xs">SMSF Borrowing - Bank Lender</td>
                                        <td> <span class="label label-sm label-success label-mini">
1 saved </span></td>
                                        <td><a class="btn default btn-xs blue-stripe" href="#">
                                                Create New </a></td>
                                    </tr>
                                    <tr>
                                        <td class="hidden-xs">SMSF Borrowing - Related Party Lender</td>
                                        <td> <span class="label label-sm label-success label-mini">
1 saved </span></td>
                                        <td><a class="btn default btn-xs blue-stripe" href="#">
                                                Create New </a></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- END SAMPLE TABLE PORTLET-->
                    <!-- BEGIN SAMPLE TABLE PORTLET-->
                    <div class="portlet">
                        <div class="portlet-title">
                            <div class="caption"><i class="fa fa-shopping-cart"></i>Estate Planning</div>
                            <div class="tools"><a class="collapse">
                                </a>
                                <a class="config" href="#portlet-config" data-toggle="modal">
                                </a>
                                <a class="reload">
                                </a>
                                <a class="remove">
                                </a></div>
                        </div>
                        <div class="portlet-body">
                            <div class="table-scrollable">
                                <table class="table table-striped table-bordered table-advance table-hover">
                                    <thead>
                                    <tr>
                                        <th class="hidden-xs"><i class="fa "></i> Document</th>
                                        <th><i class="fa fa-bookmark"></i> Price</th>
                                        <th><i class="fa fa-bookmark"></i> Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td class="hidden-xs">BDBN Review</td>
                                        <td> <span class="label label-sm label-success label-mini">
3 saved </span></td>
                                        <td><a class="btn default btn-xs green-stripe" href="#">
                                                Create New </a></td>
                                    </tr>
                                    <tr>
                                        <td class="hidden-xs">SMSF Will</td>
                                        <td></td>
                                        <td><a class="btn default btn-xs green-stripe" href="#">
                                                Create New </a></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- END SAMPLE TABLE PORTLET-->
                    <!-- BEGIN SAMPLE TABLE PORTLET-->
                    <div class="portlet">
                        <div class="portlet-title">
                            <div class="caption"><i class="fa fa-shopping-cart"></i>Trusts</div>
                            <div class="tools"><a class="collapse">
                                </a>
                                <a class="config" href="#portlet-config" data-toggle="modal">
                                </a>
                                <a class="reload">
                                </a>
                                <a class="remove">
                                </a></div>
                        </div>
                        <div class="portlet-body">
                            <div class="table-scrollable">
                                <table class="table table-striped table-bordered table-advance table-hover">
                                    <thead>
                                    <tr>
                                        <th class="hidden-xs"><i class="fa "></i> Document</th>
                                        <th><i class="fa fa-bookmark"></i> Price</th>
                                        <th><i class="fa fa-bookmark"></i> Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td class="hidden-xs">Fixed Unit Trust</td>
                                        <td> <span class="label label-sm label-success label-mini">
3 saved </span></td>
                                        <td><a class="btn default btn-xs green-stripe" href="#">
                                                Create New </a></td>
                                    </tr>
                                    <tr>
                                        <td class="hidden-xs">Discretionary Trust</td>
                                        <td></td>
                                        <td><a class="btn default btn-xs green-stripe" href="#">
                                                Create New </a></td>
                                    </tr>
                                    <tr>
                                        <td class="hidden-xs">Hybrid Trust</td>
                                        <td> <span class="label label-sm label-success label-mini">
1 saved </span></td>
                                        <td><a class="btn default btn-xs blue-stripe" href="#">
                                                Create New </a></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- END SAMPLE TABLE PORTLET-->

                </div>
                <div class="col-md-6">

                    <!-- BEGIN SAMPLE TABLE PORTLET-->
                    <div class="portlet">
                        <div class="portlet-title">
                            <div class="caption"><i class="fa fa-shopping-cart"></i>SMSF Income Streams</div>
                            <div class="tools"><a class="collapse">
                                </a>
                                <a class="config" href="#portlet-config" data-toggle="modal">
                                </a>
                                <a class="reload">
                                </a>
                                <a class="remove">
                                </a></div>
                        </div>
                        <div class="portlet-body">
                            <div class="table-scrollable">
                                <table class="table table-striped table-bordered table-advance table-hover">
                                    <thead>
                                    <tr>
                                        <th class="hidden-xs"><i class="fa "></i> Document</th>
                                        <th><i class="fa fa-bookmark"></i> Price</th>
                                        <th><i class="fa fa-bookmark"></i> Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td class="hidden-xs">Account Based Pension</td>
                                        <td> <span class="label label-sm label-success label-mini">
3 saved </span></td>
                                        <td><a class="btn default btn-xs green-stripe" href="#">
                                                Create New </a></td>
                                    </tr>
                                    <tr>
                                        <td class="hidden-xs">Transition to Retirement Income Stream</td>
                                        <td></td>
                                        <td><a class="btn default btn-xs green-stripe" href="#">
                                                Create New </a></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- END SAMPLE TABLE PORTLET-->
                    <!-- BEGIN SAMPLE TABLE PORTLET-->
                    <div class="portlet">
                        <div class="portlet-title">
                            <div class="caption"><i class="fa fa-shopping-cart"></i>Companies</div>
                            <div class="tools"><a class="collapse">
                                </a>
                                <a class="config" href="#portlet-config" data-toggle="modal">
                                </a>
                                <a class="reload">
                                </a>
                                <a class="remove">
                                </a></div>
                        </div>
                        <div class="portlet-body">
                            <div class="table-scrollable">
                                <table class="table table-striped table-bordered table-advance table-hover">
                                    <thead>
                                    <tr>
                                        <th class="hidden-xs"><i class="fa "></i> Document</th>
                                        <th><i class="fa fa-bookmark"></i> Price</th>
                                        <th><i class="fa fa-bookmark"></i> Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td class="hidden-xs">Standard Proprietary Company</td>
                                        <td> <span class="label label-sm label-success label-mini">
3 saved </span></td>
                                        <td><a class="btn default btn-xs green-stripe" href="#">
                                                Create New </a></td>
                                    </tr>
                                    <tr>
                                        <td class="hidden-xs">Special Purpose SMSF Trustee Company</td>
                                        <td></td>
                                        <td><a class="btn default btn-xs green-stripe" href="#">
                                                Create New </a></td>
                                    </tr>
                                    <tr>
                                        <td class="hidden-xs">Constitution Upgrade</td>
                                        <td></td>
                                        <td><a class="btn default btn-xs green-stripe" href="#">
                                                Create New </a></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- END SAMPLE TABLE PORTLET-->
                    <!-- BEGIN SAMPLE TABLE PORTLET-->
                    <div class="portlet">
                        <div class="portlet-title">
                            <div class="caption"><i class="fa fa-shopping-cart"></i>SMSF Compliance</div>
                            <div class="tools"><a class="collapse">
                                </a>
                                <a class="config" href="#portlet-config" data-toggle="modal">
                                </a>
                                <a class="reload">
                                </a>
                                <a class="remove">
                                </a></div>
                        </div>
                        <div class="portlet-body">
                            <div class="table-scrollable">
                                <table class="table table-striped table-bordered table-advance table-hover">
                                    <thead>
                                    <tr>
                                        <th class="hidden-xs"><i class="fa "></i> Document</th>
                                        <th><i class="fa fa-bookmark"></i> Price</th>
                                        <th><i class="fa fa-bookmark"></i> Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td class="hidden-xs">Statutory Declaration</td>
                                        <td> <span class="label label-sm label-success label-mini">
3 saved </span></td>
                                        <td><a class="btn default btn-xs green-stripe" href="#">
                                                Create New </a></td>
                                    </tr>
                                    <tr>
                                        <td class="hidden-xs">Acquire an Asset</td>
                                        <td></td>
                                        <td><a class="btn default btn-xs green-stripe" href="#">
                                                Create New </a></td>
                                    </tr>
                                    <tr>
                                        <td class="hidden-xs">Sell an Asset</td>
                                        <td> <span class="label label-sm label-success label-mini">
3 saved </span></td>
                                        <td><a class="btn default btn-xs green-stripe" href="#">
                                                Create New </a></td>
                                    </tr>
                                    <tr>
                                        <td class="hidden-xs">Satisfy Work Test</td>
                                        <td> <span class="label label-sm label-success label-mini">
3 saved </span></td>
                                        <td><a class="btn default btn-xs green-stripe" href="#">
                                                Create New </a></td>
                                    </tr>
                                    <tr>
                                        <td class="hidden-xs">Trustee Consent - Director</td>
                                        <td> <span class="label label-sm label-success label-mini">
3 saved </span></td>
                                        <td><a class="btn default btn-xs green-stripe" href="#">
                                                Create New </a></td>
                                    </tr>
                                    <tr>
                                        <td class="hidden-xs">Trustee Consent - Individual</td>
                                        <td> <span class="label label-sm label-success label-mini">
3 saved </span></td>
                                        <td><a class="btn default btn-xs green-stripe" href="#">
                                                Create New </a></td>
                                    </tr>
                                    <tr>
                                        <td class="hidden-xs">Wind-up SMSF</td>
                                        <td> <span class="label label-sm label-success label-mini">
3 saved </span></td>
                                        <td><a class="btn default btn-xs green-stripe" href="#">
                                                Create New </a></td>
                                    </tr>
                                    <tr>
                                        <td class="hidden-xs">Met Condition of Release</td>
                                        <td> <span class="label label-sm label-success label-mini">
3 saved </span></td>
                                        <td><a class="btn default btn-xs green-stripe" href="#">
                                                Create New </a></td>
                                    </tr>
                                    <tr>
                                        <td class="hidden-xs">Alter Investment Allocation</td>
                                        <td> <span class="label label-sm label-success label-mini">
3 saved </span></td>
                                        <td><a class="btn default btn-xs green-stripe" href="#">
                                                Create New </a></td>
                                    </tr>
                                    <tr>
                                        <td class="hidden-xs">Investment Strategy</td>
                                        <td> <span class="label label-sm label-success label-mini">
3 saved </span></td>
                                        <td><a class="btn default btn-xs green-stripe" href="#">
                                                Create New </a></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- END SAMPLE TABLE PORTLET-->

                </div>
                </div>
                <!-- END PAGE CONTENT-->

                <?php comments_template( '', true ); // Remove if you don't want comments ?>

                <br class="clear">

                <?php edit_post_link(); ?>

            </article>
            <!-- /article -->

        <?php endwhile; ?>

        <?php else: ?>

            <!-- article -->
            <article>

                <h2><?php _e( 'Sorry, nothing to display.', 'html5blank' ); ?></h2>

            </article>
            <!-- /article -->

        <?php endif; ?>

    </section>
    <!-- /section -->
</main>



<?php get_footer(); ?>
