(function( $ ) {

	'use strict';

	Vue.component( 'jet-wp-query', {
		template: '#jet-wp-query',
		props: [ 'value', 'dynamic-value' ],
		mixins: [
			window.JetQueryWatcherMixin,
			window.JetQueryRepeaterMixin,
		],
		data: function() {
			return {
				pageTypesOptions: window.jet_query_component_current_wp_query.page_types_options,
				query: {},
			};
		},
		created: function() {
			this.query = { ...this.value };

			if ( ! this.query.posts_per_page ) {
				this.$set( this.query, 'posts_per_page', [] );
			}

			for ( var i = 0; i < this.pageTypesOptions.length; i++ ) {

				for ( var j = 0; j < this.pageTypesOptions[ i ].options.length; i++ ) {
					this.$set(
						this.pageTypesOptions[ i ].options[ j ],
						'value',
						this.$set( this.pageTypesOptions[ i ].id + '::' + this.pageTypesOptions[ i ].options[ j ].value )
					);
				}
			}

		}
	} );

})( jQuery );
