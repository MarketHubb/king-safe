<?php if ( have_rows( 'models' ) ): ?>

<section class="models-data">

    <table class="models-table responsive">

        <thead>

            <th>MODEL</th>

            <th>EXTERIOR <span class="head-cell-extra-info">(HxWxD) </th>

            <th>INTERIOR <span class="head-cell-extra-info">(HxWxD) </th>

            <th>lbs</th>

            <th>CAPACITY <span class="head-cell-extra-info">(Cubic Feet)</span></th>

        </thead>

        <tbody>

    <?php while( have_rows( 'models' ) ): the_row(); ?>

        <tr>

            <td><?php the_sub_field( 'model_code' )?></td>

            <td><?php the_sub_field( 'model_exterior' )?></td>

            <td><?php the_sub_field( 'model_interior' )?></td>

            <td><?php the_sub_field( 'model_lbs' )?></td>

            <td><?php the_sub_field( 'model_capacity' )?></td>

        </tr>

    <?php endwhile; ?>

        </tbody>

    </table>

</section>

<?php endif; ?>

