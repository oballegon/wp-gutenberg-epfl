const { __ } = wp.i18n;

const {
	registerBlockType,
} = wp.blocks;

const {
    TextControl,
} = wp.components;

const {
	InspectorControls,
} = wp.editor

const { Fragment } = wp.element;

const maxLinksGroup = 10;

const getAttributes = () => {
    let atts = {
		'title': {
            type: 'string',
        },
        'mainUrl': {
            type: 'string',
		},
	};

    for (var i = 1; i <= maxLinksGroup; i++) {
        atts['label'+i] = {
			type: 'string',
        };
        atts['url'+i] = {
			type: 'string',
        };
    }

    return atts;
}

function LinkGroupPanel ( props ) {
    const { attributes, setAttributes, index } = props;

    const setIndexedAttributes = (field_name, value) => {
        setAttributes({[`${field_name}${index}`]: value});
     };

    // set a value or an empty string for each Control, or face :
    // https://stackoverflow.com/questions/37427508/react-changing-an-uncontrolled-input

    return (
        <div>
            <TextControl
                label={ __('Label', 'epfl') }
                value={ attributes['label' + index] || ''}
                onChange={ value => setIndexedAttributes('label', value) }
                help= { __('Link label', 'epfl') }
            />
            <TextControl
                label={ __('URL', 'epfl') }
                value={ attributes['url' + index]  || '' }
                onChange={ value => setIndexedAttributes('url', value) }
                help= { __('Link URL', 'epfl') }
            />
            <hr />
        </div>
    );
}

registerBlockType( 'epfl/links-group', {
	title: __( 'EPFL Links group', 'epfl'),
	description: 'v1.0.2',
	icon: 'editor-kitchensink',
	category: 'common',
	attributes: getAttributes(),
	supports : {
		customClassName: false, // Removes the default field in the inspector that allows you to assign a custom class
	},
	edit: ( props ) => {
        const { attributes, className, setAttributes } = props;

        return (
            <Fragment>
                <InspectorControls>
                    <p><a className="wp-block-help" href={ __('https://www.epfl.ch/campus/services/links-group-en/', 'epfl') } target="new">{ __('Online help', 'epfl') } </a></p>
                </InspectorControls>
                <div className={ className + ' wp-block-scroll' }>
                    <h2>EPFL Links group</h2>
                    <TextControl
                        label={ __('Title', 'epfl') }
                        value={ attributes.title }
                        onChange={ title => setAttributes( { title } ) }
                        help={ <a target="_blank" href="https://epfl-idevelop.github.io/elements/#/molecules/links-group">{ __('Documentation', 'epfl') }</a> }
                    />
                    <TextControl
                        label={ __('URL', 'epfl') }
                        value={ attributes.mainUrl }
                        onChange={ mainUrl => setAttributes( { mainUrl } ) }
                    />
                    <h4>Links</h4>
                    {[...Array(maxLinksGroup)].map((x, i) =>
                    <LinkGroupPanel key={i+1} { ...{ attributes, setAttributes, index:i+1 } }  />
                    )}
                </div>
            </Fragment>
		)
	},
	save: ( props ) => {
		return null;
	},
} );
