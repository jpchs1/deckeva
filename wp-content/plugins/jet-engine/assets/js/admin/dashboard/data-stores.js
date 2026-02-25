(function( $, dataStoresConfig ) {

	'use strict';

	Vue.component( 'jet-engine-data-stores', {
		template: '#jet_engine_data_stores',
		data: function() {
			return {
				dataStores: dataStoresConfig.items,
				storeTypes: dataStoresConfig.types,
				postTypes: dataStoresConfig.post_types,
				canCount: dataStoresConfig.can_posts_counts,
				nonce: dataStoresConfig._nonce,
				saving: false,
			};
		},
		methods: {
			sanitizeStoreSlug: function( value ) {

				var regex = /\s+/g;
				value = value.toLowerCase().replace( regex, '-' );
				value = this.maybeCyrToLatin( value );

				return value;
			},
			maybeCyrToLatin: function( str ) {
				var checkCyrRegex = /[а-яёїєґі]/i,
					cyrRegex = /[а-яёїєґі]/gi,
					charsMap = {
						'а': 'a', 'б': 'b', 'в': 'v', 'г': 'g', 'д': 'd',
						'е': 'e', 'ё': 'io', 'ж': 'zh', 'з': 'z', 'и': 'i',
						'й': 'i', 'к': 'k', 'л': 'l', 'м': 'm', 'н': 'n',
						'о': 'o', 'п': 'p', 'р': 'r', 'с': 's', 'т': 't',
						'у': 'u', 'ф': 'f', 'х': 'kh', 'ц': 'ts', 'ч': 'ch',
						'ш': 'sh', 'щ': 'shch', 'ы': 'y', 'э': 'e', 'ю': 'iu',
						'я': 'ia', 'ї': 'i', 'є': 'ie', 'ґ': 'g', 'і': 'i'
					};

				if ( checkCyrRegex.test( str ) ) {
					str = str.replace( cyrRegex, function( match ) {

						if ( undefined === charsMap[ match ] ) {
							return '';
						}

						return charsMap[ match ];
					} );
				}

				return str;
			},
			addNewRepeaterItem: function( item ) {
				this.dataStores.push( item );
			},
			cloneItem: function( index, keys ) {

				var item    = this.dataStores[ index ],
					newItem = {};

				for ( var i = 0; i < keys.length; i++ ) {
					newItem[ keys[ i ] ] = item[ keys[ i ] ];
				};

				this.dataStores.push( newItem );

			},
			deleteItem: function( index ) {
				this.dataStores.splice( index, 1 );
			},
			setProp: function( index, key, value ) {

				var item = this.dataStores[ index ];

				item[ key ] = value;

				if ( 'slug' === key && ! item.slug ) {
					item.slug = this.sanitizeStoreSlug( value );
				}

				this.dataStores.splice( index, 1, item );
			},
			preSetSlug: function( index ) {

				var item = this.dataStores[ index ];

				if ( ! item.slug ) {
					this.setProp( index, 'slug', this.sanitizeStoreSlug( item.name ) );
				}

			},
			isCollapsed: function( object ) {

				if ( undefined === object.collapsed || true === object.collapsed ) {
					return true;
				} else {
					return false;
				}

			},
			saveStores: function() {

				var self = this;

				self.saving = true;

				jQuery.ajax({
					url: window.ajaxurl,
					type: 'POST',
					dataType: 'json',
					data: {
						action: 'jet_engine_data_stores_save',
						nonce: self.nonce,
						items: self.dataStores,
					},
				}).done( function( response ) {
					if ( response.success ) {
						self.$CXNotice.add( {
							message: response.data.message,
							type: 'success',
							duration: 7000,
						} );
					} else {
						self.$CXNotice.add( {
							message: response.data.message,
							type: 'error',
							duration: 15000,
						} );
					}

					self.saving = false;

				} ).fail( function( jqXHR, textStatus, errorThrown ) {

					self.$CXNotice.add( {
						message: errorThrown,
						type: 'error',
						duration: 15000,
					} );

					self.saving = false;

				} );
			}
		}
	} );

})( jQuery, window.JetEngineDataStores );
