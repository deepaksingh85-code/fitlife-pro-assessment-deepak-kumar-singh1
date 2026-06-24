import { registerBlockType } from "@wordpress/blocks";

import Edit from "./edit";

registerBlockType(
	"fitlife/trainer-spotlight",
	{
		edit: Edit,
		save() {
			return null;
		}
	}
);