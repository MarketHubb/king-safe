<?php if ( have_rows( 'models') ): ?>

<section id="models-data">

    <table id="models-table">

        <thead>

            <th>Model</th>

            <th>Exterior <span class="head-cell-extra-info">(HxWxD) </th>

            <th>Interior <span class="head-cell-extra-info">(HxWxD) </th>

            <th>lbs</th>

            <th>Capacity <span class="head-cell-extra-info">(Cubic Feet)</span></th>

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

