import {
	useBlockProps,
	RichText,
	MediaUpload,
	MediaUploadCheck,
	InspectorControls,
} from "@wordpress/block-editor";

import {
	PanelBody,
	TextControl,
	SelectControl,
	Button,
} from "@wordpress/components";

export default function Edit({ attributes, setAttributes }) {

	const {
		title,
		description,
		imageUrl,
		buttonText,
		buttonUrl,
		difficulty,
	} = attributes;

	return (
		<>
			<InspectorControls>

				<PanelBody title="Program Settings">

					<TextControl
						label="Button Text"
						value={buttonText}
						onChange={(value) =>
							setAttributes({
								buttonText: value,
							})
						}
					/>

					<TextControl
						label="Button URL"
						value={buttonUrl}
						onChange={(value) =>
							setAttributes({
								buttonUrl: value,
							})
						}
					/>

					<SelectControl
						label="Difficulty"
						value={difficulty}
						options={[
							{
								label: "Beginner",
								value: "Beginner",
							},
							{
								label: "Intermediate",
								value: "Intermediate",
							},
							{
								label: "Advanced",
								value: "Advanced",
							},
						]}
						onChange={(value) =>
							setAttributes({
								difficulty: value,
							})
						}
					/>

				</PanelBody>

			</InspectorControls>

			<div {...useBlockProps()}>

				<MediaUploadCheck>

					<MediaUpload
						onSelect={(media) =>
							setAttributes({
								imageUrl: media.url,
							})
						}
						allowedTypes={["image"]}
						render={({ open }) => (
							<Button
								variant="secondary"
								onClick={open}
							>
								Select Background Image
							</Button>
						)}
					/>

				</MediaUploadCheck>

				{imageUrl && (
					<img
						src={imageUrl}
						alt=""
						style={{
							width: "100%",
							marginTop: "15px",
						}}
					/>
				)}

				<input
					type="text"
					placeholder="Program Title"
					value={title}
					onChange={(e) =>
						setAttributes({
							title: e.target.value,
						})
					}
				/>

				<RichText
					tagName="p"
					value={description}
					placeholder="Program Description"
					onChange={(value) =>
						setAttributes({
							description: value,
						})
					}
				/>

				<div
					style={{
						background: "#222",
						color: "#fff",
						display: "inline-block",
						padding: "5px 10px",
					}}
				>
					{difficulty}
				</div>

			</div>
		</>
	);
}