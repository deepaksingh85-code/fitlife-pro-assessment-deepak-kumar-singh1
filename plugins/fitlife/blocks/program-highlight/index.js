import { registerBlockType } from "@wordpress/blocks";
import Edit from "./edit";
import Save from "./save";

registerBlockType("fitlife/program-highlight", {
	edit: Edit,
	save: Save,
});