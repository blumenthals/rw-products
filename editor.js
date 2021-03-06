(function($) {
    "use strict";

    var Option = Backbone.Model.extend({
    })

    var Options = Backbone.Collection.extend({
        model: Option
    })

    var OptionGroup = Backbone.Model.extend({
        initialize: function() {
            if (!this.options) {
                this.options = new Options();
                while (this.options.length < 4) {
                    this.options.add(new Option());
                }
            }
        },
        parse: function(response) {
            if (response && response.options) {
                this.options = new Options(response.options, {parse: true});
            }
            return response;
        },
        toJSON: function() {
            var out = _.clone(this.attributes);
            out.options = this.options.toJSON();
            return out;
        }
    })

    var OptionGroups = Backbone.Collection.extend({
        model: OptionGroup
    })

    var Product = Backbone.Model.extend({
        initialize: function() {
            if (!this.options) this.options = new OptionGroups();
        },
        parse: function(response) {
            if (response && response.options) {
                this.options = new OptionGroups(response.options, {parse: true});
            }
            return response;
        },
        toJSON: function() {
            var out = _.clone(this.attributes);
            out.options = this.options.toJSON();
            return out
        }
    })

    var Products = Backbone.Collection.extend({
        model: Product,
        url: function() {
            return $('link[rel=products]').attr('href')
        }
    })

    var ProductEditorView = Backbone.View.extend({
        initialize: function() {
            this.collection = this.model.options;
            this.optionGroupViews = this.collection.map(function(option) {
                return new OptionGroupEditorView({ model: option })
            })
            this.collection.bind('add', _.bind(this.optionGroupAdded, this))
        },
        optionGroupAdded: function(option) {
            var view = new OptionGroupEditorView({model: option})
            this.optionGroupViews.push(view)
            this.$('.productOptionGroups').append(view.render().el)
        },
        render: function() {
            //this.$el.html(this.template());
            _(this.optionGroupViews).each(_.bind(function(v) {
                this.$('.productOptionGroups').append(v.render().el)
            }, this))
            return this.bindModel();
        },
        bindings: {
            'src .productImage img': 'thumbnail',
            'value [name="title"]' : 'title',
            'value [name="price"]' : 'price',
            'value [name="info"]' : 'info',
            'value [name="weight"]' : 'weight',
            'value [name="layout"]' : 'layout',
            'value [name="badge"]' : 'badge',
            'value [name="sku"]' : 'sku',
            'value [name="description2"]' : 'description2',
            'value [name="description"]' : 'description'
        },
        addOptionGroup: function() {
            this.collection.add(new OptionGroup());
        }
    });

    var OptionGroupEditorView = Backbone.View.extend({
        initialize: function() {
            this.template = _.template($('#ProductOptionGroupEditor').html())
            this.collection = this.model.options; 
            this.collection.bind('add', this.optionAdded, this);
            this.collection.bind('reset', this.onReset, this);
        },
        onReset: function() {
            this.optionViews = [];
            this.$('.productOptions').children().remove();
            this.collection.each(_.bind(this.optionAdded, this))
        },
        optionAdded: function(option) {
            var view = new OptionEditorView({model: option})
            this.optionViews.push(view)
            this.$('.productOptions').append(view.render().el)
        },
        bindings: {
            'value [name="optionGroupName"]': 'name'
        },
        render: function() {
            this.setElement(this.template())
            this.onReset();
            return this.bindModel();
        },
        events: {
            "click .addOption": function() {
                this.collection.add(new Option);
            }
        }
    })


    var OptionEditorView = Backbone.View.extend({
        initialize: function() {
            this.template = _.template($('#ProductOptionEditor').html());
        },
        bindings: {
            'value [name="optionName"]': 'name',
            'value [name="optionPrice"]': 'price'
        },
        render: function() {
            this.setElement(this.template())
            return this.bindModel();
        }
    });

    var ProductThumbnailView = Backbone.View.extend({
        initialize: function() {
            this.template = _.template($('#ProductThumbnailView').html())
            this.model.on('change:hidden', this.handleHidden, this);
        },
        events: {
            'click': 'openEditor',
            'click .doDelete': 'deleteItem',
            'click .doHide': 'hideItem'
        },
        handleHidden: function (model) {
            this.$el[model.get('hidden') ? 'addClass' : 'removeClass']('hidden');
        },
        deleteItem: function(ev) {
            ev.stopPropagation();
            if(confirm("This will permanently remove this product. If you want to temporarily disable it, please use the 'hide' button. \n\nAre you sure you wish to delete this product?")) {
                this.model.destroy();
                this.remove()
            }
        },
        hideItem: function(ev) {
            ev.stopPropagation()
            this.model.set('hidden', !this.model.get('hidden'))
            this.model.save()
        },
        openEditor: function() {
            var editor = new ProductEditorModal({model: this.model})
            editor.render().show()
        },
        bindings: {
            'src .image' : 'thumbnail',
            'text .field-title': 'title',
            'text .field-price': ['price', function(price) { return "$" + price }],
        },
        render: function() {
            this.setElement(this.template())
            this.$el.data('view', this)
            this.handleHidden(this.model);
            return this.bindModel();
        }
    });

    var ProductEditorModal = Backbone.View.extend({
        initialize: function() {
            this.template = _.template($('#productsEditorTemplate').html())
        },
        render: function() {
            this.setElement(this.template(this.model));
            this.productsView = new ProductEditorView({el: this.$('.modal-body'), model: this.model});
            this.productsView.render();

            this.$el.modal({show: false}).hide();
            return this;
        },
        events: {
            'click .addOptionGroup': 'addOptionGroup',
            'click .dump': 'dump',
            'change .file-upload input': 'uploadImage',
            'click .btn.save': 'save',
            'click [data-dismiss=modal]': 'close'
        },
        uploadImage: function() {
            var self = this;
            this.$('.file-upload iframe').one('load', function() {
                self.$('.file-upload').get(0).reset();
                var imageData = JSON.parse(self.$('.file-upload iframe').contents().contents().text());
                self.model.set('image', imageData.$insertAll.gallery[0].image);
                self.model.set('thumbnail', imageData.$insertAll.gallery[0].thumbnail);
            })
            this.$('.file-upload').submit();
        },
        addOptionGroup: function() {
            this.productsView.addOptionGroup();
        },
        dump: function() {
            console.log(this.model.toJSON())
        },
        save: function() {
            this.model.save();
            this.$el.modal('hide');
            this.$el.remove();
        },
        show: function() {
            this.$el.modal('show');
        },
        close: function() {
            this.$el.modal('hide');
            this.$el.remove();
            if (this.model.isNew()) {
                this.model.destroy();
            }
        }
    });

    var ProductListView = Backbone.View.extend({
        events: {
            'sortupdate': 'handleSortUpdate'
        },
        initialize: function() {
            _.bindAll(this);
            this.collection.bind('add', _.bind(this.productAdded, this))
            this.collection.bind('reset', _.bind(this.render, this))
            this.collection.bind('remove', this.productRemoved, this)
        },
        render: function(e) {
            this.productViews = [];
            this.$el.children('.rw-product-thumbnail').remove();
            this.collection.each(_.bind(this.appendChildView, this))
            this.$el.sortable({ forcePlaceholderSize: true, tolerance: 'pointer' });
            return this;
        },
        appendChildView: function(product) {
            var view = new ProductThumbnailView({model: product})
            this.productViews[product.cid] = view;
            this.$('.insertion-point').before(view.render().$el);
        },
        productAdded: function(product) {
            this.appendChildView(product)
            this.handleSortUpdate();
        },
        productRemoved: function(product) {
            this.productViews[product.cid].$el.remove();
            delete this.productViews[product.cid]; 
        },
        handleSortUpdate: function() {
            var i = 0;
            this.$('.rw-product-thumbnail').each(function() {
                var model = $(this).data('view').model
                if (model.get('sortOrder') != ++i)  {
                    model.set('sortOrder', i)
                    // Check model.isNew to make sure this isn't an object mid-save already
                    if (!model.isNew()) model.save()
                }
            })
        },
    });

    var GlobalSetting = Backbone.Model.extend({
        idAttribute: 'name'
    })

    var GlobalSettings = Backbone.Collection.extend({
        model: GlobalSetting,
        url: function() {
            return $('link[rel=productsSettings]').attr('href')
        }
    });

    var GlobalSettingsView = Backbone.View.extend({
        initialize: function() {
            this.collection = new GlobalSettings;
            this.$el.modal({show: false}).hide();
        },
        show: function() {
            this.$el.modal('show');
        },
        events: {
            'click .btn': function() {
                this.$el.modal('hide');
                this.collection.each(function(e) {
                    e.save();
                });
            },
            'change input[type=checkbox]': function(ev) {
                var target = $(ev.target);
                var model;
                if (!(model = this.collection.get(target.attr('name')))) {
                    model = new GlobalSetting({name: target.attr('name')});
                    this.collection.add(model);
                }
                model.set('value', target.is(':checked') ? 1 : 0);
            }
        }
    });

    $(function() {
        var products = new Products();
        var allProducts = new Products();
        allProducts.url = allProducts.url + '/..';
        
        var productListView = new ProductListView({el: $('.rw-products'), collection: products});

        products.fetch();
        allProducts.fetch();

        $('#products_editor').on('click', '#addproduct', function(ev) {
            var product = new Product;
            products.add(product);
            var editor = new ProductEditorModal({model: product})
            editor.render().show();
        })

        var globalSettingsView = new GlobalSettingsView({el: $('#global_settings_modal')});

        $('#global_settings').on('click', function(ev) {
            globalSettingsView.show();
        });
    })

    Backbone.View.Binders.src = function(model, attribute, property) {
        return {
            get: function() {
                return this.attr('src');
            },
            set: function(value) {
                this.attr('src', value);
            }
        };
    };

})(jQuery);
