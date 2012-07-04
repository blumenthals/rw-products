(function($) {
    var Option = Backbone.Model.extend({
    })

    var Options = Backbone.Collection.extend({
        model: Option
    })

    var OptionGroup = Backbone.Model.extend({
        initialize: function() {
            if (!this.options) {
                this.options = new Options();
            }
            while (this.options.length < 4) {
                this.options.add(new Option());
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
            var out = _.clone(this.attributes)
            out.options = this.options.toJSON()           
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
                console.log(v);
                this.$('.productOptionGroups').append(v.render().el)
            }, this))
            return this.bindModel();
        },
        bindings: {
            'src .productImage img': 'image',
            'value [name="title"]' : 'title',
            'value [name="price"]' : 'price',
            'value [name="info"]' : 'info',
            'value [name="weight"]' : 'weight',
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
            this.optionViews = this.collection.map(function(option) {
                return new OptionEditorView({ model: option })
            });
            this.collection.bind('add', _.bind(this.optionAdded, this));
            this.collection.bind('reset', _.bind(this.onReset, this))
            this.onReset();
        },
        onReset: function() {
            this.optionViews = [];
            this.$el.children().remove();
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
            _.each(this.optionViews, _.bind(function(view) {
                this.$el.append(view.render().$el);
            }, this));
            return this.bindModel();
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
        },
        events: {
            'click': 'openEditor'
        },
        openEditor: function() {
            var editor = new ProductEditorModal({model: this.model})
            editor.render().show();
        },
        bindings: {
            'text .field-title': 'title',
            'text .field-price': 'price'
        },
        render: function() {
            this.setElement(this.template())
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
            'click .btn.save': 'save'
        },
        uploadImage: function() {
            var self = this;
            this.$('.file-upload iframe').one('load', function() {
                self.$('.file-upload').get(0).reset();
                var imageData = JSON.parse(self.$('.file-upload iframe').contents().contents().text());
                console.log(imageData);
                self.model.set('image', imageData.$insertAll.gallery[0].image);
                //self.model.set('thumbnail', imageData.$insertAll.gallery.[0].thumbnail);
            })
            console.log("submitting");
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
        },
        show: function() {
            this.$el.modal('show');
        },
        close: function() {
            this.$el.remove();
        }
    });

    var ProductListView = Backbone.View.extend({
        initialize: function() {
            this.collection.bind('add', _.bind(this.productAdded, this))
            this.collection.bind('reset', _.bind(this.onReset, this))
            this.onReset();
        },
        onReset: function(e) {
            this.productViews = [];
            this.$el.children().remove();
            this.collection.each(_.bind(this.productAdded, this))
        },
        render: function() {
            _.each(this.productViews, _.bind(function(view) {
                this.$el.append(view.$el);
            }, this));
            return this;
        },
        productAdded: function(product) {
            var view = new ProductThumbnailView({model: product})
            this.productViews.push(view)
            this.$el.append(view.render().$el);
        }
    });

    $(function() {
        var products = new Products();
        window.p = products;

        products.fetch({success: function() {
            var productListView = new ProductListView({collection: products});
            window.v = productListView;
            $('.rw-products').append(productListView.render().$el);
        }})

        $('#products_editor').on('click', '#addproduct', function(ev) {
            var product = new Product;
            products.add(product);
            var editor = new ProductEditorModal({model: product})
            editor.render().show();
        })
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
