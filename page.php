<?php
get_header();

$page_slug = $post->post_name ?: 'default';

$folder_index = locate_template("template-parts/pages/{$page_slug}/index.php");
$file_template = locate_template("template-parts/pages/{$page_slug}.php");
?>

<main class="main-content">
	<?php
	if ($folder_index) {
		get_template_part("template-parts/pages/{$page_slug}/index");
	} elseif ($file_template) {
		get_template_part("template-parts/pages/{$page_slug}");
	} else {
		get_template_part('template-parts/pages/default');
	}
	?>
</main>

<?php
get_footer();
