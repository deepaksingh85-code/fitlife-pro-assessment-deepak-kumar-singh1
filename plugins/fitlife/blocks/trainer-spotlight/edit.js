import {
	useBlockProps,
	InspectorControls
} from "@wordpress/block-editor";

import {
	PanelBody,
	SelectControl
} from "@wordpress/components";

import {
	useEffect,
	useState
} from "@wordpress/element";

export default function Edit({
	attributes,
	setAttributes
}) {

	const {
		trainerId
	} = attributes;

	const [
		trainers,
		setTrainers
	] = useState([]);

	useEffect(() => {

		fetch('/wp-json/wp/v2/fitlife_trainer')

			.then(
				(response) =>
					response.json()
			)

			.then(
				(data) =>
					setTrainers(data)
			);

	}, []);

	return (

		<div {...useBlockProps()}>

			<InspectorControls>

				<PanelBody title="Trainer Settings">

					<SelectControl

						label="Select Trainer"

						value={trainerId}

						options={[
							{
								label:
									'Select Trainer',
								value: 0
							},

							...trainers.map(
								(trainer) => ({
									label:
										trainer.title.rendered,
									value:
										trainer.id
								})
							)

						]}

						onChange={(value) =>
							setAttributes({
								trainerId:
									parseInt(value)
							})
						}

					/>

				</PanelBody>

			</InspectorControls>

			<h3>
				Trainer Spotlight
			</h3>

			<p>
				Selected Trainer ID:
				{trainerId}
			</p>

		</div>

	);

}