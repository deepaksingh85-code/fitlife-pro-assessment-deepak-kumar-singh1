import {
	useBlockProps,
	RichText,
} from "@wordpress/block-editor";

export default function Save({
	attributes,
}) {

	const {
		title,
		description,
		imageUrl,
		buttonText,
		buttonUrl,
		difficulty,
	} = attributes;

	return (
		<div {...useBlockProps.save()}>

			{imageUrl && (
	<img
		src={imageUrl}
		alt=""
		style={{
			width: "100%",
			height: "350px",
			objectFit: "cover",
			borderRadius: "12px",
			display: "block",
			marginBottom: "20px",
		}}
	/>
)}git add wp-content
git status

			<span className="difficulty-badge">
				{difficulty}
			</span>

			<h2>{title}</h2>

			<RichText.Content
				tagName="p"
				value={description}
			/>

			<a
				href={buttonUrl}
				className="btn-primary"
			>
				{buttonText}
			</a>

		</div>
	);
}