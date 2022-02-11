var Tracker = require("../../../assets/js/components/insights/tracker");
var ObjectSearch = require("../../../assets/js/components/faq/object_search.js");
var FaqFunctions = require("../../../assets/js/components/faq/functions.js");
var FaqCollections = require("../../../assets/js/components/faq/collections.js");
var Pagination = require("../../../assets/js/components/faq/pagination.js");

var selectors = {
	accordions: ".helpie-faq.accordions",
	faqSearch: ".helpie-faq .search__wrapper .search__input",
	accordion: ".accordion",
	accordionShow: "accordion--show",
	accordionHide: "accordion--hide",
	accordionHeading: ".accordion__heading",
	accordionHeadingShow: "accordion__heading--show",
	accordionHeadingHide: "accordion__heading--hide",
	accordionHeader: ".accordion .accordion__item .accordion__header",
	accordionItem: ".accordion__item",
	accordionItemShow: "accordion__item--show",
	accordionItemHide: "accordion__item--hide",
	accordionBody: ".accordion__body",
	searchMessage: ".search .search__message",
	searchMessageContent:
		"<p class='search__message__content'>" + faqStrings.noFaqsFound + "</p>",
};

var Stylus = {
	//setup before functions
	searchTerm: "",
	typingTimer: 0, // timer identifier
	doneTypingInterval: 2000, // time in ms, 2 second for example
	paginationEnabled: "0",

	setSearchAttr: function () {
		/* Add 'search_attr' to accordion headers */
		jQuery(selectors.accordionHeader).each(function () {
			var searchAttr = jQuery(this).text().toLowerCase();
			jQuery(this).attr("data-search-term", searchAttr);
		});
	},

	isContentMatch: function (element, searchTerm) {
		var content = jQuery(element)
			.find(selectors.accordionBody)
			.text()
			.toLowerCase();
		if (content.indexOf(searchTerm) >= 0) return true;

		return false;
	},

	isTitleMatch: function (element, searchTerm) {
		var content = jQuery(element)
			.find(".accordion__header")
			.attr("data-search-term");
		if (content == undefined || content == "undefined") {
			return false;
		}
		if (content.search(searchTerm) >= 0) {
			return true;
		}
		return false;
	},

	isCategoryHeadingMatch: function (element, searchTerm) {
		var content = jQuery(element)
			.prev(selectors.accordionHeading)
			.text()
			.toLowerCase();
		if (content.indexOf(searchTerm) >= 0) {
			return true;
		}
		return false;
	},

	isCategroryAccordionMatch: function (element, searchTerm) {
		if (jQuery(element).hasClass("accordion__category") == false) {
			return false;
		}
		var thisModule = this;
		return thisModule.isTitleMatch(element, searchTerm);
	},

	searchByAccordionItem: function (element, props) {
		let thisModule = this;
		searchTerm = thisModule.searchTerm;

		let titleMatch = thisModule.isTitleMatch(element, searchTerm);
		let contentMatch = thisModule.isContentMatch(element, searchTerm);
		//tags
		let tagsMatch = thisModule.searchByTags(element, searchTerm);

		var show = titleMatch || contentMatch || tagsMatch ? true : false;
		thisModule.displayAccordionItem(element, show);
		return show;
	},

	onSearchKeyup: function (that) {
		var thisModule = this;
		const searchTerm = thisModule.searchTerm;
		console.log("*** onSearchKeyup() ***");

		jQuery(that)
			.closest(selectors.accordions)
			.children(selectors.accordion)
			.each(function () {
				var $accordion = jQuery(this);
				var showThatAccordion = false;
				var categoryHeadingMatch = thisModule.isCategoryHeadingMatch(
					$accordion,
					searchTerm
				);

				if (categoryHeadingMatch == true) {
					showThatAccordion = true;
					thisModule.showAccordionSection($accordion, showThatAccordion);
				} else {
					$accordion.children(selectors.accordionItem).each(function () {
						$accordionItem = jQuery(this);

						var hasCategory = $accordionItem.hasClass("accordion__category");
						console.log(" [hasCategory]: " + hasCategory);

						// check the current accordion has a accordion__category class and match that accordion
						let categoryMatched = thisModule.searchByCategory(
							$accordionItem,
							searchTerm
						);

						// let define a variable for use of show the current category with accordions, when hasCategory and categoryMatched variables are matched.
						let showCategoryWithAccordions =
							hasCategory && categoryMatched ? true : false;

						// let define a varible for want to search category inner accordions, if showCategoryWithAccordions var value as false
						let searchCategoryInnerAccordions =
							showCategoryWithAccordions == false ? true : false;

						// searching category inner accordions
						let innerAccordionsContentMatched = false;
						if (searchCategoryInnerAccordions) {
							innerAccordionsContentMatched =
								thisModule.searchInnerAccordionsItems(
									$accordionItem,
									searchTerm
								);
						}

						// let define a varible for searching normal accordion, if FAQ display mode as simple accordion

						let searchSingleAccordionItem = hasCategory == false ? true : false;

						let accordionMatched = false;
						// find & show the accordion item
						if (searchSingleAccordionItem) {
							accordionMatched = thisModule.searchByAccordionItem(
								$accordionItem,
								{}
							);
						}

						// show the category with accordions
						if (hasCategory && innerAccordionsContentMatched == false) {
							thisModule.showCategoryWithAccordions(
								$accordionItem,
								showCategoryWithAccordions
							);
						}

						// show the accordion with closest category accordion
						if (
							searchCategoryInnerAccordions &&
							innerAccordionsContentMatched
						) {
							thisModule.showAccordionBelongsToCategory($accordionItem, true);
						}

						if (showThatAccordion == false) {
							// show the closest accordion, if anyone category accordion text is matched.
							if (showCategoryWithAccordions == true) {
								showThatAccordion = true;
							}

							// show the closest accordion, if category inner accordions items title, content, or tags are matched
							if (
								searchCategoryInnerAccordions == true &&
								innerAccordionsContentMatched == true
							) {
								showThatAccordion = true;
							}

							// show the accordion, if simple accordion matched.
							if (
								searchSingleAccordionItem == true &&
								accordionMatched == true
							) {
								showThatAccordion = true;
							}
						}
					});
				}

				thisModule.displayHeading($accordion, showThatAccordion);
				thisModule.showAccordion($accordion, showThatAccordion);
			});
	},

	searchByCategory: function ($categoryAccordion, searchTerm) {
		let thisModule = this;
		let categoryAccordionMatched = thisModule.isCategroryAccordionMatch(
			$categoryAccordion,
			searchTerm
		);
		return categoryAccordionMatched;
	},
	searchInnerAccordionsItems: function ($categoryAccordion, searchTerm) {
		let thisModule = this;
		let show = false;
		// loop the current accordion and get inner accordions items.
		$categoryAccordion.find(selectors.accordionItem).each(function () {
			$item = jQuery(this);
			let itemMatched = thisModule.searchByAccordionItem($item, {});
			if (itemMatched == true) {
				show = true;
			}
		});
		return show;
	},

	init: function () {
		var thisModule = this;
		console.log("Search init");
		thisModule.setSearchAttr();
		jQuery("body").on("keyup", selectors.faqSearch, function (event) {
			var searchValue = jQuery(this)
				.val()
				.toLowerCase()
				.replace(/[.*+?^${}()|[\]\\]/gi, "");

			thisModule.searchTerm = searchValue;
			let elementsObject = FaqFunctions.getElements(this);
			thisModule.paginationEnabled = FaqFunctions.paginationEnabled(this);

			// don't show the empty faqs block, if users entering the keywords for filtering faqs
			thisModule.canSeeEmptyFAQsBlock(this, "hide");

			if (thisModule.searchTerm == "" && thisModule.paginationEnabled == "1") {
				jQuery(elementsObject.root).attr("data-search", "0");
				thisModule.showAllAccordionsFromObject(this);

				return false;
			}

			if (thisModule.searchTerm == "" && thisModule.paginationEnabled != "1") {
				// show all faqs, if search term has an empty.
				thisModule.showAllAccordions(this);
				return false;
			}

			/***
			 * Note:- Should enable the pagination to the current shortcode (or) widgets
			 */
			if (thisModule.paginationEnabled == "1") {
				jQuery(elementsObject.root).attr("data-search", "1");
				ObjectSearch.init(this, searchValue);
			} else {
				thisModule.onSearchKeyup(this);
			}

			// shown not found faq's content
			thisModule.showEmptyFAQsContent(this);

			// use of condition for avoid to tracking empty search term.
			if (thisModule.searchTerm == "") {
				return false;
			}

			// For ajaxCall, start the countdown
			clearTimeout(thisModule.typingTimer);
			thisModule.typingTimer = setTimeout(function () {
				// donetyping() method
				// For Tracking, searching Keywords
				Tracker.searchCounter(thisModule.searchTerm);
			}, thisModule.doneTypingInterval);
		});
	},

	showAllAccordions: function (that) {
		var thisModule = this;
		let canDisplay = true;
		jQuery(that)
			.closest(selectors.accordions)
			.children(selectors.accordion)
			.each(function () {
				let $accordion = jQuery(this);

				//show accordion
				thisModule.showAccordion($accordion, canDisplay);

				//show heading
				thisModule.displayHeading($accordion, canDisplay);

				// show inner accordion
				$accordion
					.find(selectors.accordion)
					.removeClass(selectors.accordionHide)
					.addClass(selectors.accordionShow);

				//show accordion items
				$accordion
					.find(selectors.accordionItem)
					.removeClass(selectors.accordionItemHide)
					.addClass(selectors.accordionItemShow);
			});
	},
	showEmptyFAQsContent: function (that) {
		var thisModule = this;
		var hiddenFaqsCount = 0;

		var totalFaqsCount = jQuery(that)
			.closest(selectors.accordions)
			.find(selectors.accordionItem).length;

		jQuery(that)
			.closest(selectors.accordions)
			.find(selectors.accordionItem)
			.each(function () {
				// count all hidden faqs
				if (jQuery(this).is(":visible") == false) {
					hiddenFaqsCount = parseInt(hiddenFaqsCount) + 1;
				}
			});

		// check hidden faqs-count with overall faq-count, return if not match both counts.
		if (hiddenFaqsCount != totalFaqsCount) {
			return;
		}

		jQuery(that)
			.closest(selectors.accordions)
			.find(selectors.accordion)
			.each(function () {
				let $accordion = jQuery(this);
				thisModule.displayHeading($accordion, false);
				thisModule.showAccordion($accordion, false);
			});

		// append & show the not found faq text block
		jQuery(that)
			.closest(selectors.accordions)
			.find(selectors.searchMessage)
			.empty()
			.show()
			.append(selectors.searchMessageContent);
	},

	canSeeEmptyFAQsBlock: function (that, status) {
		var canSeeElement = "none";
		if (status == "show") {
			canSeeElement = "block";
		}
		jQuery(that)
			.closest(selectors.accordions)
			.find(selectors.searchMessage)
			.css("display", canSeeElement);
	},

	displayAccordionItem: function (event, canDisplay) {
		const addClassName =
			canDisplay == true
				? selectors.accordionItemShow
				: selectors.accordionItemHide;

		const removeClassName =
			canDisplay == false
				? selectors.accordionItemShow
				: selectors.accordionItemHide;

		event.removeClass(removeClassName).addClass(addClassName);
	},

	displayHeading: function (event, canDisplay) {
		const addClassName =
			canDisplay == true
				? selectors.accordionHeadingShow
				: selectors.accordionHeadingHide;

		const removeClassName =
			canDisplay == false
				? selectors.accordionHeadingShow
				: selectors.accordionHeadingHide;

		event
			.prev(selectors.accordionHeading)
			.removeClass(removeClassName)
			.addClass(addClassName);
	},
	showCategoryAccordions: function (element, canDisplay) {
		const addClassName =
			canDisplay == true
				? selectors.accordionItemShow
				: selectors.accordionItemHide;

		const removeClassName =
			canDisplay == false
				? selectors.accordionItemShow
				: selectors.accordionItemHide;

		jQuery(element)
			.find(selectors.accordionItem)
			.removeClass(removeClassName)
			.addClass(addClassName);
	},

	showAccordionSection: function (element, canDisplay) {
		var thisModule = this;

		thisModule.displayHeading(element, canDisplay);
		thisModule.showCategoryAccordions(element, canDisplay);
		thisModule.showAccordion(element, canDisplay);
	},

	showAccordion: function (element, canDisplay) {
		const addClassName =
			canDisplay == true ? selectors.accordionShow : selectors.accordionHide;

		const removeClassName =
			canDisplay == false ? selectors.accordionShow : selectors.accordionHide;

		jQuery(element).removeClass(removeClassName).addClass(addClassName);
	},
	showCategoryWithAccordions: function (element, canDisplay) {
		var thisModule = this;
		thisModule.displayAccordionItem(element, canDisplay);
		thisModule.showCategoryAccordions(element, canDisplay);
		thisModule.showAccordion(element, canDisplay);
	},
	showAccordionBelongsToCategory: function (element, canDisplay) {
		var thisModule = this;
		jQuery(element)
			.find(selectors.accordion)
			.removeClass(selectors.accordionHide)
			.addClass(selectors.accordionShow);
		thisModule.displayAccordionItem(element, canDisplay);
	},
	searchByTags: function (element, searchTerm) {
		let tags = jQuery(element).find(".accordion__header").attr("data-tags");
		let foundTag = false;
		if (tags == undefined || tags == "undefined" || tags.length == 0) {
			return foundTag;
		}
		tags.split(",").forEach(function (tag) {
			tag = tag.toLowerCase();
			if (tag.search(searchTerm) != -1) {
				foundTag = true;
			}
		});
		return foundTag;
	},

	showAllAccordionsFromObject: function (element) {
		let elementsObject = FaqFunctions.getElements(element);
		let currenPageNo = FaqFunctions.getPaginationCurrentPage(elementsObject);
		let shortcodeIndex = FaqFunctions.getShortcodeIndex(elementsObject);

		let paginateData = {
			page: currenPageNo,
		};

		let viewProps = FaqCollections.getCurrentShortcodeViewProps(shortcodeIndex);

		let totalNoOfPage = FaqCollections.getTotalNoOfPages(viewProps);

		let thisPageViewProps = FaqCollections.getCurrentPageViewProps(
			paginateData,
			{
				collection: viewProps.collection,
				items: viewProps.items,
			}
		);

		FaqFunctions.appendFaqsContent(elementsObject, thisPageViewProps);
		Pagination.renderPageLinks(elementsObject.pagination, {
			current: currenPageNo,
			last: totalNoOfPage,
		});
	},
};

module.exports = Stylus;
