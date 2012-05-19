(function($) {
    /*
    var productTemplate = {
        name: "Product Name Here",
        id: "productID",
        price: "0.00",
        taxable: false,
        weight: "15",
        imageURL: "",
        options: {
            Category: [ 
                {
                    name: "Option Name",
                    price: "0.00"
                }
            ]
        }
    };
    */

    var ProductOption = Backbone.Model.extend({
    })

    var ProductOptions = Backbone.Collection.extend({
        model: ProductOption
    })

    var Product = Backbone.Model.extend({
        initialize: function() {
            this.set('options', new ProductOptions())
        },
        embeds: {
            options: ProductOptions,
        },
        parse: function(response) {
            response.options = new ProductOptions(response.options, {parse: true});
        }
    })

    var ProductView = Backbone.View.extend({
        initialize: function() {
            this.collection = this.model.get('options')
            this.modelBinder = new Backbone.ModelBinder;
            this.optionViews = this.collection.map(function(option) {
                new ProductOptionView({ model: option })
            })
            this.collection.bind('add', _.bind(this.optionAdded, this))
            this.render();
        },
        optionAdded: function(option) {
            console.log('option added')
            var view = new ProductOptionView({model: option})
            this.optionViews.push(view)
            if (this._rendered) this.$('.productOptions').append(view.render().el)
        },
        render: function() {
            this._rendered = true;
            //this.$el.html(this.template());
            _(this.optionViews).each(_.bind(function(option) {
                this.$('.productOptions').append(option.render().el)
            }, this))
            this.modelBinder.bind(this.model, this.el);
            return this;
        },
        close: function(){
            this.modelBinder.unbind();
        },
        addOption: function() {
            console.log('product.addOption')
            this.collection.add(new ProductOption());
        }
    });

    var ProductOptionView = Backbone.View.extend({
        initialize: function() {
            this.template = _.template($('#optionTemplate').html())
            this.render();
        },
        render: function() {
            this.setElement(this.template(this.model))
            return this;
        }
    })

    var ProductEditorView = Backbone.View.extend({
        initialize: function() {
            this.template = _.template($('#productsEditorTemplate').html())
            this.render();
            this.productsView = new ProductView({el: this.$('.modal-body'), model: this.model});
        },
        render: function() {
            this.setElement(this.template(this.model));
            this.$el.modal({show: false}).hide();
            return this;
        },
        events: {
            'click .addOption': 'addOption'
        },
        addOption: function() {
            console.log('editor.addOption');
            this.productsView.addOption();
        },
        show: function() {
            this.$el.modal('show');
        }
    })

    $(function() {
        /*
        if(!pagedata.plugins.products) pagedata.plugins.products= {};
        if(!pagedata.plugins.products.products) pagedata.plugins.products.products = [];

        var ta = $('textarea[name=products]')

        var validate = function validate() {
            try {
                pagedata.plugins.products= JSON.parse(this.value)
                $('#status').text('Valid')
                $('input,button').attr('disabled', null);
            } catch(e) {
                $('#status').text('invalid')
                $('input,button').attr('disabled', 'disabled');
            }
        }

        var update = function update(data) {
            ta.attr('disabled', null)
            ta.val(JSON.stringify(data, undefined, 1))
            validate.apply(ta.get(0))
            pagedata.plugins.products= data
        }

        ta.change(validate)
        ta.keyup(validate)

        update(pagedata.plugins.products)
       */

        var editor = new ProductEditorView({model: new Product})

        $('#addproduct').click(function(ev) {
            editor.show();
        })
    })
})(jQuery);
